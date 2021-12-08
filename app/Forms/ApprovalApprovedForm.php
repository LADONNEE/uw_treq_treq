<?php
namespace App\Forms;

use App\Events\TaskUpdated;
use App\Models\Task;
use App\Trackers\TaskLog;

class ApprovalApprovedForm extends TaskCompletedForm
{
    public function commit()
    {
        $this->task->fill([
            'response' => Task::RESPONSE_APPROVED,
            'message' => $this->value('message'),
            'completed_by' => user()->person_id,
            'completed_at' => now(),
        ]);
        $this->task->save();

        TaskLog::write($this->task, user()->person_id, "approved {$this->task->name}");

        event(new TaskUpdated($this->task, user()));
    }
}
