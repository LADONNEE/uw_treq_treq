<?php
namespace App\Repositories;

use App\Models\Order;
use App\Models\Progress;
use App\Models\Task;
use App\Utilities\LaravelQueryView;

class WorkflowRepository
{
    public function countIncomplete($order_id, $taskType)
    {
        return (int) Task::where('order_id', $order_id)
            ->where('type', $taskType)
            ->whereNull('completed_at')
            ->count();
    }

    public function deletePendingBudgetTask($order_id, $budgetno)
    {
        Task::where('order_id', $order_id)
            ->where('budgetno', $budgetno)
            ->whereNull('completed_at')
            ->delete();
    }

    public function firstOrNewTask($order_id, $taskType): Task
    {
        return Task::firstOrNew([
            'order_id' => $order_id,
            'type' => $taskType,
        ]);
    }

    public function firstTaskByType($order_id, $type)
    {
        return Task::where('order_id', $order_id)
            ->where('type', $type)
            ->notSentBack()
            ->first();
    }

    /**
     * @param int $order_id
     * @return Task[]
     */
    public function getTasks($order_id)
    {
        return Task::where('order_id', $order_id)->get();
    }

    public function revertToCreating($order_id, $clearStep = null)
    {
        Order::where('id', $order_id)->update([
            'stage' => Order::STAGE_CREATING,
            'submitted_at' => null,
        ]);

        if ($clearStep) {
            Progress::where('order_id', $order_id)
                ->where('step', $clearStep)
                ->delete();
        }
    }

    public function store(Task $task)
    {
        $task->save();
    }
}
