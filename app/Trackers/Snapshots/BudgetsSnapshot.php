<?php
namespace App\Trackers\Snapshots;

use App\Models\Order;

class BudgetsSnapshot extends SnapshotList
{
    public function __construct(Order $order)
    {
        $order = $order->fresh();
        foreach ($order->budgets as $budget) {
            $this->addItem($budget->budgetno, $budget->splitDescription());
        }
    }

    public function getItemLabel(): string
    {
        return 'budgets';
    }
}
