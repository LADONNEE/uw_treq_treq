<?php
namespace App\Http\Controllers;

use App\Events\StepCompleted;
use App\Models\Budget;
use App\Models\Item;
use App\Models\Order;
use App\Models\Perdiem;
use App\Models\Project;
use App\Models\Task;

class AddOrderToProject extends Controller
{
    public function __invoke(Project $project)
    {
        $type = request('type');
        if (!isset(Order::$types[$type])) {
            abort(404);
        }

        $order = new Order([
            'type' => request('type'),
            'project_id' => $project->id,
            'stage' => Order::STAGE_CREATING,
            'submitted_by' => user()->person_id,
        ]);
        $order->save();

        if (!$order->isPreAuth()) {
            $pre = $this->getPreAuth($project->id, $order->id);
            if ($pre) {
                $this->copyItems($pre, $order);
                $this->copyPerdiem($pre, $order);
                $this->copyBudgets($pre, $order);
                $this->copyDeptApproval($pre, $order);
            }
        }

        event(new StepCompleted($order, 'project', user()));

        return redirect()->route('next', $order->id);
    }

    private function copyItems(Order $pre, Order $new)
    {
        foreach ($pre->items as $item) {
            $exists = Item::where('order_id', $new->id)->where('name', $item->name)->count();
            if (!$exists) {
                $i = new Item([
                    'order_id' => $new->id,
                    'name' => $item->name,
                    'url' => $item->url,
                    'amount' => $item->amount,
                ]);
                $i->save();
            }
        }
    }

    private function copyPerdiem(Order $pre, Order $new)
    {
        if (!$pre->perdiem) {
            return;
        }

        $perdiem = Perdiem::firstOrNew(['order_id' => $new->id]);
        $data = $pre->perdiem->toArray();
        unset($data['order_id']);
        $perdiem->fill($data);
        $perdiem->save();
    }

    private function copyBudgets(Order $pre, Order $new)
    {
        foreach ($pre->budgets as $budget) {
            $exists = Budget::where('order_id', $new->id)->where('budgetno', $budget->budgetno)->count();
            if (!$exists) {
                $b = new Budget([
                    'order_id' => $new->id,
                    'budgetno' => $budget->budgetno,
                    'pca_code' => $budget->pca_code,
                    'project_code_id' => $budget->project_code_id,
                    'opt_code' => $budget->opt_code,
                    'name' => $budget->name,
                    'split_type' => $budget->split_type,
                    'split' => $budget->split,
                ]);
                $b->save();
            }
        }
    }

    private function copyDeptApproval(Order $pre, Order $new)
    {
        $exists = Task::where('order_id', $new->id)->where('type', 'department')->count();
        if ($exists) {
            return;
        }

        $dept = $this->getDeptApproval($pre->id);
        if (!$dept) {
            return;
        }

        $t = new Task([
            'order_id' => $new->id,
            'type' => $dept->type,
            'name' => 'Department Pre-Auth',
            'sequence' => $dept->sequence,
            'is_approval' => $dept->is_approval,
            'description' => 'Spend Authorizer Approval was provided on pre-authorization for this project',
            'created_by' => $dept->created_by,
            'assigned_to' => $dept->assigned_to,
            'notified_at' => now(),
            'response' => 'Approved',
            'completed_by' => $dept->completed_by,
            'completed_at' => $dept->completed_at,
        ]);
        $t->save();
    }

    /**
     * @param int $order_id
     * @return Task|null
     */
    private function getDeptApproval($order_id)
    {
        return Task::where('order_id', $order_id)
            ->where('type', 'department')
            ->where('response', 'Approved')
            ->first();
    }

    /**
     * @param int $project_id
     * @param int $notOrderId
     * @return Order|null
     */
    private function getPreAuth($project_id, $notOrderId)
    {
        return Order::where('project_id', $project_id)
            ->where('id', '<>', $notOrderId)
            ->where('stage', '<>', 'Canceled')
            ->whereIn('type', ['pre-auth', 'travel-pre-auth'])
            ->first();
    }
}
