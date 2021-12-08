<?php

namespace App\Http\Controllers;

use App\Models\Order;

class PrintOrder
{
    public function __invoke(Order $order)
    {
        $project = $order->project;
        return view('print.show', compact('order', 'project'));
    }
}
