<?php
namespace App\Forms;

use App\Events\TaskAdded;
use App\Models\Order;
use App\Models\Person;
use App\Models\Task;
use App\Trackers\TaskLog;

class TaskCreateForm extends Form
{
    protected $order;
    public $task;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function createInputs()
    {
        $this->add('person_id');
        $this->add('name');
        $this->add('description');
    }

    public function validate()
    {
        $this->checkPersonExists();
        $this->check('name')->notEmpty();
    }

    public function commit()
    {
        $this->task = new Task([
            'order_id' => $this->order->id,
            'type' => Task::TYPE_TASK,
            'name' => $this->value('name'),
            'sequence' => 0,
            'is_approval' => false,
            'description' => $this->value('description'),
            'created_by' => user()->person_id,
            'assigned_to' => $this->value('person_id'),
        ]);
        $this->task->save();

        TaskLog::write($this->task, user()->person_id, "added task {$this->task->name}");

        event(new TaskAdded($this->task, user()));
    }

    protected function checkPersonExists($input = 'person_id')
    {
        $this->check($input, function($person_id, $hasError, $values) {
            $p = Person::where('person_id', $person_id)->first();
            if (!$p || !$p->exists) {
                $hasError("Person_id {$person_id} does not exist");
            }
        });
    }
}
