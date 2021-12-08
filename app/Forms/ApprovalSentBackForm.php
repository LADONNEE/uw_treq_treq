<?php
namespace App\Forms;

use App\Events\TaskUpdated;
use App\Models\Task;
use App\Trackers\TaskLog;

class ApprovalSentBackForm extends TaskCompletedForm
{
    public function commit()
    {
        $this->task->fill([
            'response' => Task::RESPONSE_SENTBACK,
            'message' => $this->value('message'),
            'completed_by' => user()->person_id,
            'completed_at' => now(),
        ]);
        $this->task->save();

        $this->task->order->sendBack();

        TaskLog::write($this->task, user()->person_id, "sent back {$this->task->name}");

        event(new TaskUpdated($this->task, user()));
    }
}
