<?php

namespace App\Reports;

use App\Models\Order;

class MyTasksReport extends MyOrdersReport
{
    private $dontIncludeStages = [
        Order::STAGE_COMPLETE,
        Order::STAGE_CANCELED,
    ];

    public function load()
    {
        return Order::select('orders.*')
            ->orderBy('submitted_at')
            ->join('needs_action_view', 'orders.id', '=', 'needs_action_view.order_id')
            ->whereNotNull('orders.submitted_at')
            ->whereNotIn('orders.stage', $this->dontIncludeStages)
            ->where('needs_action_view.assigned_to', $this->person_id)
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
