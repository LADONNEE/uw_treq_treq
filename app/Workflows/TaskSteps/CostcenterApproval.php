<?php
namespace App\Workflows\TaskSteps;

use App\Models\Budget;
use App\Models\Order;
use App\Models\Task;
use App\Workflows\ApproversByWorktag;

class CostcenterApproval extends TaskStep
{
    public $stage = Order::STAGE_BUDGET;
    public $taskType = Task::TYPE_BUDGET;
    public $hasTask = true;

    public function activate(): void
    {
        $approvers = new ApproversByWorktag();
        $needs = $this->getCostcenterWorktags();
        $has = $this->getTaskCostcenters();

        foreach ($needs as $wd_costcenter) {
            if (!in_array($wd_costcenter, $has)) {
                $this->makeTask($wd_costcenter, $approvers->get($wd_costcenter));
            }
        }

        foreach ($has as $wd_costcenter) {
            if (!in_array($wd_costcenter, $needs)) {
                $this->repo->deletePendingBudgetTask($this->order->id, $wd_costcenter);
            }
        }
    }

    public function isComplete(): bool
    {
        $tasks = $this->repo->getTasks($this->order->id);

        foreach ($tasks as $task) {
            if ($task->isBudgetApproval()) {
                if (!$task->isApproved()) {
                    return false;
                }
            }
        }
        return true;
    }

    private function getCostcenterWorktags()
    {
        return Budget::where('order_id', $this->order->id)
            ->pluck('wd_costcenter')
            ->all();
    }

    private function getTaskCostcenters()
    {
        $out = [];
        foreach ($this->order->tasks as $task) {
            if ($task->budgetno && !$task->isSentBack()) {
                $out[] = $task->budgetno;
            }
        }
        return $out;
    }

    private function makeTask($wd_costcenter, $assign_to)
    {
        $task = new Task([
            'order_id' => $this->order->id,
            'type' => $this->taskType,
            'name' => "Cost center Approval {$wd_costcenter}",
            'sequence' => 1,
            'is_approval' => true,
            'budgetno' => $wd_costcenter,
            'assigned_to' => $assign_to,
            'created_by' => $this->order->submitted_by,
        ]);
        $task->save();
    }
}
