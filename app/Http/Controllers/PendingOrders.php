<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Reports\HomeCollection;

class PendingOrders extends Controller
{
    public function __invoke($stage)
    {
        switch ($stage) {
            case 'all':
                $title = 'All Pending';
                $orders = $this->allOrders();
                break;
            case 'department':
                $title = 'Pending Spend Authorizer Approval';
                $orders = $this->departmentOrders();
                break;
            case 'budget':
                $title = 'Pending Budget Approval';
                $orders = $this->budgetOrders();
                break;
            default:
                $title = 'Pending Task or Ad-Hoc Approval';
                $orders = $this->taskOrders();
                break;
        }

        if (wantsCsv()) {
            return response()->view('pending-orders.csv', compact('orders'));
        }

        return view('pending-orders.index', compact('title', 'orders'));
    }

    private function allOrders()
    {
        $reports = new HomeCollection(user());
        return $reports->pending->orders;
    }

    private function departmentOrders()
    {
        return Order::whereNotNull('submitted_at')
            ->where('stage', Order::STAGE_DEPARTMENT)
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }

    private function budgetOrders()
    {
        return Order::whereNotNull('submitted_at')
            ->where('stage', Order::STAGE_BUDGET)
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }

    private function taskOrders()
    {
        return Order::whereNotNull('submitted_at')
            ->whereNotIn('stage', [Order::STAGE_COMPLETE, Order::STAGE_CANCELED, Order::STAGE_DEPARTMENT, Order::STAGE_BUDGET])
            ->orderBy('created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
