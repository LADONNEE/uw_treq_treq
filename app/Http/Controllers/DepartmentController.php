<?php
namespace App\Http\Controllers;

use App\Events\StepCompleted;
use App\Events\TaskUpdated;
use App\Forms\DepartmentApprovalForm;
use App\Models\Order;
use App\Models\Task;
use App\Trackers\LoggedSubmit;

class DepartmentController extends Controller
{
    public function create(Order $order)
    {
        $project = $order->project;

        $approval = $this->getDeptApproval($order->id);
        if ($approval) {
            return view('department.edit', compact('order', 'project', 'approval'));
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
}
