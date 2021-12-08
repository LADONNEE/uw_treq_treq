<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLog;

class Log extends Controller
{
    public function __invoke(Order $order)
    {
        $logs = OrderLog::where('order_id', $order->id)
            ->orWhere('project_id', $order->project_id)
            ->orderBy('created_at', 'desc')
            ->with('actor')
            ->get();

        if (request()->ajax()) {
            return view('log/_table', compact('order', 'logs'));
        }

        return view('log/index', compact('order', 'logs'));
    }
}
