<?php

namespace App\Http\Controllers;

use App\Api\ItemsApi;
use App\Models\Order;

class ItemsApiState extends Controller
{
    private $travelItems = [
        'Airfare',
        'Registration',
        'Car Service',
        'Car Rental',
        'Mileage',
    ];

    public function __invoke(Order $order, $trip = null)
    {
        $defaults =  ($trip === 'trip') ? $this->travelItems : [];
        $items = new ItemsApi($order, $defaults);

        return response()->json($items->toArray());
    }
}
