<?php
namespace App\Workflows\TaskSteps;

use App\Models\Order;
use App\Models\Task;

class DepartmentApproval extends TaskStep
{
    public $stage = Order::STAGE_DEPARTMENT;
    public $taskType = Task::TYPE_DEPARTMENT;

    public function activate(): void
    {
        if (!$this->hasDepartmentApprovalRequest()) {
            $this->repo->revertToCreating($this->order->id, 'department');
        }
    }

    public function isComplete(): bool
    {
        return (bool) Task::where('order_id', $this->order->id)
            ->where('type', Task::TYPE_DEPARTMENT)
            ->where('response', Task::RESPONSE_APPROVED)
            ->count();
    }

    private function hasDepartmentApprovalRequest()
    {
        return (bool) Task::where('order_id', $this->order->id)
            ->where('type', Task::TYPE_DEPARTMENT)
            ->where(function($query) {
                $query->whereNull('response')->orWhere('response', '<>', Task::RESPONSE_SENTBACK);
            })
            ->count();
    }
}
