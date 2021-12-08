<?php
namespace App\Forms;

use App\Events\TaskUpdated;
use App\Models\Person;
use App\Models\Task;
use App\Trackers\TaskLog;

class ReassignTaskForm extends Form
{
    public $task;
    private $person;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function createInputs()
    {
        $this->add('person_id');
    }

    public function validate()
    {
        $person_id = $this->value('person_id');
        $this->person = Person::where('person_id', $person_id)->first();
        if (!$this->person || !$this->person->exists) {
            $this->input('person_id')->error("Person_id {$person_id} does not exist");
        }
    }

    public function commit()
    {
        $assign_to = $this->person->person_id;

        if ($this->task->assigned_to == $assign_to) {
            return;
        }

        $this->task->assigned_to = $assign_to;
        $this->task->notified_at = null;
        $this->task->created_by = user()->person_id;
        $this->task->save();

        TaskLog::write($this->task, user()->person_id, "reassigned task {$this->task->name} to " . eFirstLast($this->person));

        event(new TaskUpdated($this->task, user()));
    }
}
