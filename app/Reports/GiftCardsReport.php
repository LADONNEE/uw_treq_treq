<?php

namespace App\Reports;

use App\Models\Order;

class GiftCardsReport extends OrdersReport
{
    public function load()
    {
        return Order::select('orders.*')
            ->join('projects', 'orders.project_id', '=', 'projects.id')
            ->where('projects.is_gift_card', 1)
            ->whereNotNull('orders.submitted_at')
            ->where('stage', '<>', Order::STAGE_CANCELED)
            ->orderBy('orders.submitted_at', 'desc')
            ->get();
    }
}
