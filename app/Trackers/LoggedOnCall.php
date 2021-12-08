<?php

namespace App\Trackers;

use App\Models\Order;
use App\Models\OrderLog;

class LoggedOnCall
{
    private $order;
    private $actor_id;

    public $shouldLog = true;

    public function __construct(Order $order, $actor_id)
    {
        $this->order = $order;
        $this->actor_id = $actor_id;
    }

    public function toggle()
    {
        if ($this->order->on_call) {
            $this->order->on_call = false;
            $this->order->save();
            $this->writeLog('removed On Call flag');
        } else {
            $this->order->on_call = true;
            $this->order->save();
            $this->writeLog('added On Call flag');
        }
    }

    protected function writeLog($message)
    {
        if (!$this->shouldLog) {
            return;
        }
        $log = new OrderLog([
            'order_id' => $this->order->id,
            'actor_id' => $this->actor_id,
            'message' => $message,
        ]);
        $log->save();
    }
}
