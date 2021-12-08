<?php

namespace App\Trackers;

use App\Api\ItemsApi;
use App\Models\Order;
use App\Models\OrderLog;
use App\Trackers\Snapshots\ItemsSnapshot;

class LoggedItems
{
    private $order;
    private $patch;
    private $actor_id;

    public $shouldLog = true;

    public function __construct(Order $order, $patch, $actor_id)
    {
        $this->order = $order;
        $this->patch = $patch;
        $this->actor_id = $actor_id;
    }

    public function execute()
    {
        $before = ($this->shouldLog) ? new ItemsSnapshot($this->order) : null;

        $items = new ItemsApi($this->order, []);
        $items->save($this->patch);

        if (!$before) {
            return;
        }

        $diff = $before->diff(new ItemsSnapshot($this->order));

        if ($diff->isEmpty()) {
            return;
        }

        $this->writeLog($diff->getMessage());
    }

    protected function writeLog($message)
    {
        $log = new OrderLog([
            'order_id' => $this->order->id,
            'actor_id' => $this->actor_id,
            'project_id' => null,
            'message' => $message,
        ]);
        $log->save();
    }
}
