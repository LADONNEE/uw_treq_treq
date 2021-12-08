<?php
namespace App\Forms;

use App\Events\TaskUpdated;
use App\Trackers\TaskLog;

class TaskDeleteForm extends TaskCompletedForm
{
    public function commit()
    {
        $this->task->delete();

        TaskLog::write($this->task, user()->person_id, "deleted task {$this->task->name}");

        event(new TaskUpdated($this->task, user()));
    }
}
