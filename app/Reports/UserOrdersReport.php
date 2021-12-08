<?php

namespace App\Reports;

use App\Auth\User;
use App\Models\Order;

class UserOrdersReport
{
    public function getReport($person_id)
    {
        return $this->creatingOrders($person_id)
            ->concat($this->pendingOrders($person_id))
            ->concat($this->completeOrders($person_id))
            ->concat($this->canceledOrders($person_id));
    }

    private function creatingOrders($person_id)
    {
        return Order::where('submitted_by', $person_id)
            ->whereNull('submitted_at')
            ->where('stage', '<>', Order::STAGE_CANCELED)
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }

    private function pendingOrders($person_id)
    {
        return Order::where('submitted_by', $person_id)
            ->whereNotNull('submitted_at')
            ->whereNotIn('stage', [Order::STAGE_COMPLETE, Order::STAGE_CANCELED])
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }

    private function completeOrders($person_id)
    {
        return Order::where('submitted_by', $person_id)
            ->where('stage', Order::STAGE_COMPLETE)
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }

    private function canceledOrders($person_id)
    {
        return Order::where('submitted_by', $person_id)
            ->where('stage', Order::STAGE_CANCELED)
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
