<?php
namespace App\Forms;

use App\Events\TaskUpdated;
use App\Models\Task;
use App\Trackers\TaskLog;

class TaskCompletedForm extends Form
{
    public $task;
    protected $responseValue = Task::RESPONSE_COMPLETED;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function createInputs()
    {
        $this->add('message');
    }

    public function validate()
    {
        // no validation needed
    }

    public function commit()
    {
        $this->task->fill([
            'response' => $this->responseValue,
            'message' => $this->value('message'),
            'completed_by' => user()->person_id,
            'completed_at' => now(),
        ]);
        $this->task->save();

        TaskLog::write($this->task, user()->person_id, "completed task {$this->task->name}");

        event(new TaskUpdated($this->task, user()));
    }
}
