<?php
namespace App\Workflows\TaskSteps;

use App\Models\Order;
use App\Repositories\WorkflowRepository;

abstract class TaskStep
{
    public $stage = '(unknown stage)';
    public $taskType = '';
    public $hasTask = false;

    protected $order;
    protected $repo;

    public function __construct(Order $order, WorkflowRepository $repo)
    {
        $this->order = $order;
        $this->repo = $repo;
    }

    abstract public function activate(): void;

    abstract public function isComplete(): bool;

    public function getStage(): string
    {
        return $this->stage;
    }

    public function hasIncompleteTasks($taskType): bool
    {
        return $this->repo->countIncomplete($this->order->id, $taskType) > 0;
    }
}
