<?php

namespace App\Exceptions;

use App\Models\Order;

class OrderLockedException extends \Exception
{
    public $order;
    public $message;

    public function __construct(Order $order, $field)
    {
        $this->order = $order;
        $this->message = "Order is locked. Can not change {$field}.";
        parent::__construct($this->message);
    }
}
