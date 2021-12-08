<?php

namespace App\Reports;

use App\Models\Order;

class PendingOrders extends OrdersReport
{
    public $countDepartment = 0;
    public $countBudget = 0;
    public $countTask = 0;

    public function load()
    {
        $orders = Order::whereNotNull('submitted_at')
            ->whereNotIn('stage', [Order::STAGE_COMPLETE, Order::STAGE_CANCELED])
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();

        foreach ($orders as $order) {
            if ($order->stage === Order::STAGE_DEPARTMENT) {
                $this->countDepartment += 1;
                continue;
            }
            if ($order->stage === Order::STAGE_BUDGET) {
                $this->countBudget += 1;
                continue;
            }
            $this->countTask += 1;
        }

        return $orders;
    }
}
