<?php

namespace App\Trackers;

use App\Models\Order;
use App\Models\OrderLog;

class LoggedCancel
{
    private $order;
    private $actor_id;

    public $shouldLog = true;

    public function __construct(Order $order, $actor_id)
    {
        $this->order = $order;
        $this->actor_id = $actor_id;
    }

    public function execute()
    {
        if ($this->order->isCanceled()) {
            return;
        }

        $this->order->cancel();

        $this->writeLog('canceled order');
    }

    protected function writeLog($message)
    {
        $log = new OrderLog([
            'order_id' => $this->order->id,
            'actor_id' => $this->actor_id,
            'message' => $message,
        ]);
        $log->save();
    }
}
