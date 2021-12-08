<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderReadOnlyPartial extends Controller
{
    public function __invoke(Order $order)
    {
        return view('orders._order-ro', compact('order'));
    }
}
