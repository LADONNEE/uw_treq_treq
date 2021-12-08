<?php

namespace App\Trackers;

use App\Api\BudgetsApi;
use App\Models\Order;
use App\Models\OrderLog;
use App\Trackers\Snapshots\BudgetsSnapshot;

class LoggedBudgets
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
        $before = ($this->shouldLog) ? new BudgetsSnapshot($this->order) : null;

        $api = new BudgetsApi($this->order);
        $api->save($this->patch);

        if (!$before) {
            return;
        }

        $diff = $before->diff(new BudgetsSnapshot($this->order));

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
