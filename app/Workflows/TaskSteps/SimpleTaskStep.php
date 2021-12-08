<?php
namespace App\Workflows\TaskSteps;

/**
 * SimpleTaskSteps are Tasks that must be completed once within a Workflow.
 * There needs to be exactly one instance of this Task (that has not been
 * Sent Back) and this step is resolved when the Task instance has been
 * Approved or Completed.
 *
 * Examples: EnterInAriba, PlaceOrder
 *
 * To implement a SimpleTaskStep just provide the public properties
 * $stage and $taskType.
 */
class SimpleTaskStep extends TaskStep
{
    public $hasTask = true;

    public function activate(): void
    {
        if (!$this->repo->firstTaskByType($this->order->id, $this->taskType)) {
            $this->createTask();
        }
    }

    public function isComplete(): bool
    {
        foreach ($this->order->tasks as $task) {
            if ($task->type === $this->taskType && $task->isApproved()) {
                return true;
            }
        }
        return false;
    }

    public function assignTo(): int
    {
        return $this->order->assigned_to ?? setting('default-fiscal');
    }

    protected function createTask()
    {
        $task = $this->repo->firstOrNewTask($this->order->id, $this->taskType);
        $task->fill([
            'name' => $this->stage,
            'sequence' => 1,
            'is_approval' => false,
            'assigned_to' => $this->assignTo(),
            'created_by' => $this->order->submitted_by
        ]);
        $this->repo->store($task);
    }
}
