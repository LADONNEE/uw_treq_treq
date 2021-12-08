<?php

namespace App\Http\Controllers;

use App\Api\BudgetsApi;
use App\Models\Order;

class BudgetsApiState extends Controller
{
    public function __invoke(Order $order)
    {
        $api = new BudgetsApi($order);

        return response()->json($api->toArray());
    }
}
