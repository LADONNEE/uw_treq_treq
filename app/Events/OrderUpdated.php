<?php
namespace App\Events;

use App\Models\Order;

interface OrderUpdated
{
    public function getOrder(): Order;
}
