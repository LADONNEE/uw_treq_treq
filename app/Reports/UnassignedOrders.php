<?php

namespace App\Reports;

use App\Models\Order;

class UnassignedOrders extends OrdersReport
{
    public function load()
    {
        return Order::whereNotNull('submitted_at')
            ->where('stage', Order::STAGE_UNASSIGNED)
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
