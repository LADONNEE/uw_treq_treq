<?php
namespace Tests\Workflows;

use App\Models\Task;
use App\Repositories\WorkflowRepository;

class WorkflowRepositoryDouble extends WorkflowRepository
{
    private $tasks;

    public function __construct()
    {
        $this->tasks = collect([]);
    }

    /* Test rigging */



    /* WorkflowRepository interface */

    public function deletePendingBudgetTask($order_id, $budgetno)
    {
        foreach ($this->tasks as $task) {
            if ($task->budgetno === $budgetno && !$task->completed_at) {
                unset($this->tasks[$task->_key]);
            }
        }
    }

    public function getAribaApproval($order_id)
    {
        foreach ($this->tasks as $task) {
            if ($task->type === Task::TYPE_ARIBA && !$task->response !== Task::RESPONSE_SENTBACK) {
                return $task;
            }
        }
        return null;
    }

    public function getDepartmentApproval($order_id)
    {
        foreach ($this->tasks as $task) {
            if ($task->type === Task::TYPE_DEPARTMENT && !$task->response !== Task::RESPONSE_SENTBACK) {
                return $task;
            }
        }
        return null;
    }

    /**
     * @param int $order_id
     * @return Task[]
     */
    public function getTasks($order_id)
    {
        return $this->tasks;
    }

    public function revertToCreating($order_id, $clearStep = null)
    {

    }

    public function store(Task $task)
    {
        if ($task->_key) {
            $this->tasks[$task->_key] = $task;
        } else {
            $key = count($this->tasks);
            $task->_key = $key;
            $this->tasks[$key] = $task;
        }
    }
}
