<?php

namespace App\Notifications;

use App\Models\Order;

class PendingEmailHeader
{
    public $project_id;
    public $title;
    public $order_id;
    public $to;
    public $type;

    public function __construct(Order $order, $to, $type)
    {
        $this->project_id = $order->project_id;
        $this->title = $order->project->title;
        $this->order_id = $order->id;
        $this->to = $to;
        $this->type = $type;
    }
}
