<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Trackers\LoggedOnCall;

class OnCallApiController extends Controller
{
    public function show(Order $order)
    {
        return response()->json([
            'order_id' => $order->id,
            'on_call' => ($order->on_call) ? 1 : 0,
        ]);
    }

    public function update(Order $order)
    {
        $this->authorize('on-call');

        $cmd = new LoggedOnCall($order, user()->person_id);
        $cmd->toggle();

        return response()->json([
            'result' => 'updated',
            'order_id' => $order->id,
            'on_call' => ($order->on_call) ? 1 : 0,
        ]);
    }
}
