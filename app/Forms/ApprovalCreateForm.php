<?php
namespace App\Forms;

use App\Events\TaskAdded;
use App\Models\Task;
use App\Trackers\TaskLog;

class ApprovalCreateForm extends TaskCreateForm
{
    public function validate()
    {
        $this->checkPersonExists();
    }

    public function commit()
    {
        $this->task = new Task([
            'order_id' => $this->order->id,
            'type' => Task::TYPE_APPROVAL,
            'name' => 'Approval',
            'sequence' => 0,
            'is_approval' => true,
            'description' => $this->value('description'),
            'created_by' => user()->person_id,
            'assigned_to' => $this->value('person_id'),
        ]);
        $this->task->save();

        $message = 'requested approval from ' . eFirstLast($this->task->assignee);
        TaskLog::write($this->task, user()->person_id, $message);

        event(new TaskAdded($this->task, user()));
    }
}
