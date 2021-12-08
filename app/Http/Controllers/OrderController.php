<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Workflows\CanIEdit;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        if (isAjax() || request('part')) {
            return view('orders._order-ro', compact('order'));
        }
        $project = $order->project;
        $canEdit = new CanIEdit($order, user());
        return view('orders.show', compact('project', 'order', 'canEdit'));
    }

    private function isTravel($type)
    {
        return strpos($type, 'travel-') === 0;
    }
}
