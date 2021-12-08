<?php

namespace App\Http\Controllers;

use App\Mail\TestMessage;
use App\Models\Order;
use App\Utilities\MailSender;

class OrderRefreshApi extends Controller
{
    public function __invoke(Order $order)
    {
        $project = $order->project;
        return response()->json([
            'stage' => $order->stage,
            'assigned' => ($order->assigned_to) ? 'Contact: ' . eFirstLast($order->assignee) : null,
            'projectButtons' => view('projects._project-buttons', compact('order', 'project'))->render()
        ]);
    }
}
