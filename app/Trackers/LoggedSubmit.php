<?php

namespace App\Trackers;

use App\Models\Order;
use App\Models\OrderLog;

class LoggedSubmit
{
    private $order;
    private $actor_id;
    private $task_id;

    public $shouldLog = true;

    public function __construct(Order $order, $actor_id, $task_id = null)
    {
        $this->order = $order;
        $this->actor_id = $actor_id;
        $this->task_id = $task_id;
    }

    public function execute()
    {
        if ($this->order->submitted_at) {
            return;
        }

        $this->order->submitted_at = now();
        $this->order->submitted_by = $this->actor_id;
        $this->order->save();

        $this->writeLog('submitted order');
    }

    protected function writeLog($message)
    {
        $log = new OrderLog([
            'order_id' => $this->order->id,
            'actor_id' => $this->actor_id,
            'task_id' => $this->task_id,
            'message' => $message,
        ]);
        $log->save();
    }
}
