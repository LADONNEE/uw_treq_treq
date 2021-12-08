<?php

namespace App\Reports;

use App\Models\Order;

class OnCallOrders extends OrdersReport
{
    public function load()
    {
        return Order::where('on_call', 1)
            ->whereNotNull('submitted_at')
            ->whereNotIn('stage', [Order::STAGE_COMPLETE, Order::STAGE_CANCELED])
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
