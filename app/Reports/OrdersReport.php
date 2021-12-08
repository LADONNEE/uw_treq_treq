<?php

namespace App\Reports;

abstract class OrdersReport
{
    public $count = 0;
    public $orders;

    public function __construct()
    {
        $this->orders = $this->load();
        $this->count = count($this->orders);
    }

    abstract public function load();
}
