<?php
namespace App\Http\Controllers;

use App\Events\StepCompleted;
use App\Events\TaskUpdated;
use App\Forms\DepartmentApprovalForm;
use App\Models\Order;
use App\Models\Task;
use App\Models\Budget;
use App\Trackers\LoggedSubmit;
use Illuminate\Support\Facades\DB;
use Config;


class DepartmentController extends Controller
{
    public function create(Order $order)
    {
        $project = $order->project;

        $approval = $this->getDeptApproval($order->id);
        if ($approval) {
            return view('department.edit', compact('order', 'project', 'approval'));
        }

        //Generate multiple Department Approval Tasks
        if(!$this->orderHasDeptApprovalTasks($order->id)){
            $project_codes = $this->getOrderProjectCodes($order->id);
        
            foreach($project_codes as $project_code){
                $this->makeTask($order->id, $project_code, $this->getProjectCodeAuthorizers($project_code->id)->authorizer_person_id);
            }
        }
        
        

        $form = new DepartmentApprovalForm($order);
        return view('department.create', compact('order', 'project', 'form'));
    }

    public function store(Order $order)
    {
        $form = new DepartmentApprovalForm($order);
        if ($form->process()) {
            return redirect()->route('next', $order->id);
        }
        return redirect()->back();
    }

    public function update(Order $order)
    {
        $approval = $this->getDeptApproval($order->id);
        if (!$approval) {
            return redirect()->route('department', $order->id);
        }

        $cmd = new LoggedSubmit($order, user()->person_id);
        $cmd->execute();

        event(new StepCompleted($order, 'department', user()));
        event(new TaskUpdated($approval, user()));

        return redirect()->route('next', $order->id);
    }

    private function getDeptApproval($order_id)
    {
        return Task::where('order_id', $order_id)
            ->where('type', Task::TYPE_DEPARTMENT)
            ->where('response', 'Approved')
            ->first();
    }

    private function orderHasDeptApprovalTasks($order_id)
    {
        return Task::where('order_id', $order_id)
            ->where('type', Task::TYPE_DEPARTMENT)
            ->first();
    }

    /**
     * Handle Multi Department Approvers / Authorizers
     */

    private function getOrderProjectCodes($order_id)
    {
        return DB::table('budgets AS b')
            ->select(['b.project_code_id AS id', 'b.pca_code'])
            ->where('b.order_id', $order_id)
            ->get();
    }

    private function getProjectCodeAuthorizers($project_code_id)
    {
        return DB::table(Config::get('app.database_shared') . '.project_codes AS pc')
            ->select(['pc.authorizer_person_id', 'pc.fiscal_person_id'])
            ->where('pc.id', $project_code_id)
            ->first();
    }

    private function makeTask($order_id, $project_code, $assign_to)
    {
        $task = new Task([
            'order_id' => $order_id,
            'type' => Task::TYPE_DEPARTMENT,
            'name' => $project_code->pca_code ? "Department Approval | " . $project_code->pca_code : "Department Approval",
            'assigned_to' => $assign_to,
            'created_by' => user()->person_id,
            'sequence' => 1,
            'is_approval' => true,
            'description' => '',
            'assigned_to' => $assign_to,
        ]);
        $task->save();

        // event(new StepCompleted($this->order, 'department', user()));
        // event(new TaskUpdated($this->task, user()));
    }

}
