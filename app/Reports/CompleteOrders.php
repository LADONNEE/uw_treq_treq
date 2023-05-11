<?php

namespace App\Reports;

use App\Models\Order;

class CompleteOrders extends OrdersReport
{
    public function load()
    {
        return Order::where('stage', Order::STAGE_COMPLETE)
            ->whereNotNull('submitted_at')
            ->whereNotIn('stage', [Order::STAGE_CANCELED])
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
