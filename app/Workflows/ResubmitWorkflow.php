<?php

namespace App\Workflows;

use App\Models\Order;
use App\Models\Task;
use App\Trackers\TaskLog;
use App\Utilities\ChooseFiscalContact;

class ResubmitWorkflow
{
    private $order;
    private $note;
    private $person_id;

    public function __construct(Order $order, $note, $person_id)
    {
        $this->order = $order;
        $this->note = $note;
        $this->person_id = $person_id;
    }

    public function resubmit()
    {
        if ($this->hasDepartmentApproval()) {
            $deptSentBack = false;
        } else {
            $deptSentBack = $this->getDepartmentSentBack();
        }

        if ($deptSentBack) {
            $this->makeNewDepartmentApproval($deptSentBack);
        } else {
            $this->makeReviewResubmitTask();
        }

        $this->order->resubmit(user()->person_id);
    }

    private function hasDepartmentApproval()
    {
        return (bool) Task::where('order_id', $this->order->id)
            ->where('type', Task::TYPE_DEPARTMENT)
            ->where('response', Task::RESPONSE_APPROVED)
            ->count();
    }

    private function getDepartmentSentBack()
    {
        return Task::where('order_id', $this->order->id)
            ->where('type', Task::TYPE_DEPARTMENT)
            ->where('response', Task::RESPONSE_SENTBACK)
            ->orderBy('completed_at', 'desc')
            ->first();
    }

    private function makeNewDepartmentApproval(Task $original)
    {
        $task = new Task([
            'order_id' => $this->order->id,
            'type' => Task::TYPE_DEPARTMENT,
            'name' => $original->name,
            'sequence' => $original->sequence,
            'is_approval' => 1,
            'budgetno' => $original->budgetno,
            'description' => $this->note,
            'created_by' => $this->person_id,
            'assigned_to' => $original->assigned_to,
        ]);
        $task->save();

        TaskLog::write($task, user()->person_id, "order resubmitted for department approval");
    }

    private function makeReviewResubmitTask()
    {
        $task = new Task([
            'order_id' => $this->order->id,
            'type' => Task::TYPE_TASK,
            'name' => 'Review Re-Submitted Order',
            'sequence' => 0,
            'is_approval' => false,
            'description' => $this->note,
            'created_by' => $this->person_id,
            'assigned_to' => $this->fiscalContactPersonId(),
        ]);
        $task->save();

        TaskLog::write($task, user()->person_id, "order resubmitted");
    }

    private function fiscalContactPersonId(): int
    {
        if ($this->order->assigned_to) {
            return $this->order->assigned_to;
        }

        $choose = new ChooseFiscalContact();
        return $choose->contactFor($this->order->id);
    }
}
