<?php

namespace App\Reports;

use App\Models\Order;

class MyCreatingReport extends MyOrdersReport
{
    public function load()
    {
        return Order::where('submitted_by', $this->person_id)
            ->whereIn('stage', [Order::STAGE_CREATING, Order::STAGE_SENT_BACK])
            ->orderBy('created_at', 'desc')
            ->with('project', 'submitter')
            ->get();
    }
}
