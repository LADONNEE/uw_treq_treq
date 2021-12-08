<?php

namespace App\Reports;

use App\Models\Order;

class RecentOrdersReport extends OrdersReport
{
    public function load()
    {
        return Order::whereNotNull('submitted_at')
            ->whereIn('stage', [Order::STAGE_COMPLETE, Order::STAGE_CANCELED])
            ->where('updated_at', '>', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
