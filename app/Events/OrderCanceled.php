<?php
namespace App\Events;

use App\Auth\User;
use App\Models\Order;

class OrderCanceled implements OrderUpdated
{
    public $order;
    public $user;

    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
