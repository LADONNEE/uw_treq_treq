<?php
namespace App\Workflows\TaskSteps;

use App\Models\Budget;
use App\Models\Order;
use App\Models\Task;
use App\Workflows\ApproversByBudget;

class BudgetApproval extends TaskStep
{
    public $stage = Order::STAGE_BUDGET;
    public $taskType = Task::TYPE_BUDGET;
    public $hasTask = true;

    public function activate(): void
    {
        $approvers = new ApproversByBudget();
        $needs = $this->getBudgetNumbers();
        $has = $this->getTaskBudgets();

        foreach ($needs as $budgetno) {
            if (!in_array($budgetno, $has)) {
                $this->makeTask($budgetno, $approvers->get($budgetno));
            }
        }

        foreach ($has as $budgetno) {
            if (!in_array($budgetno, $needs)) {
                $this->repo->deletePendingBudgetTask($this->order->id, $budgetno);
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

    private function getBudgetNumbers()
    {
        return Budget::where('order_id', $this->order->id)
            ->pluck('budgetno')
            ->all();
    }

    private function getTaskBudgets()
    {
        $out = [];
        foreach ($this->order->tasks as $task) {
            if ($task->budgetno && !$task->isSentBack()) {
                $out[] = $task->budgetno;
            }
        }
        return $out;
    }

    private function makeTask($budgetno, $assign_to)
    {
        $task = new Task([
            'order_id' => $this->order->id,
            'type' => $this->taskType,
            'name' => "Budget Approval {$budgetno}",
            'sequence' => 1,
            'is_approval' => true,
            'budgetno' => $budgetno,
            'assigned_to' => $assign_to,
            'created_by' => $this->order->submitted_by,
        ]);
        $task->save();
    }
}
