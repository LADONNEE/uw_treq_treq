<?php
namespace App\Api;

use App\Models\Order;

class OrderApiBrief
{
    private $data;

    public function __construct(Order $order)
    {
        $this->data = $order->toArray();
        $this->data['typeName'] = $order->typeName();
        $this->data['submittedName'] = eFirstLast($order->submitted_by);
        $this->data['assignedToName'] = eFirstLast($order->assigned_to);
        $this->data['url'] = route('order-api', $order->id);
    }

    public function toArray()
    {
        return $this->data;
    }
}
