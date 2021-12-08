<?php

namespace App\Http\Controllers;

use App\Api\PerdiemApi;
use App\Models\Order;

class PerdiemApiState extends Controller
{
    public function __invoke(Order $order)
    {
        $perdiem = (new PerdiemApi($order))->formState();

        return response()->json($perdiem);
    }
}
