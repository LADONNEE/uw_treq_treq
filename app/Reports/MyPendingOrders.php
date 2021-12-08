<?php

namespace App\Reports;

use App\Models\Order;

class MyPendingOrders extends MyOrdersReport
{
    public function load()
    {
        return Order::where('submitted_by', $this->person_id)
            ->whereNotNull('submitted_at')
            ->where(function($query) {
                $query->whereNotIn('stage', [Order::STAGE_COMPLETE, Order::STAGE_CANCELED])
                    ->orWhere('updated_at', '>', now()->subDays(30));
            })
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
