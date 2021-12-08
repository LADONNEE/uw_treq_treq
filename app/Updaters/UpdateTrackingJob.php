<?php
namespace App\Updaters;

use App\Models\Order;
use App\Models\Tracking;
use App\Workflows\StageToTaskType;
use Illuminate\Support\Facades\DB;

class UpdateTrackingJob
{
    private $all;

    public function __construct($all)
    {
        $this->all = $all;
    }

    public function run()
    {
        Tracking::$map = new StageToTaskType();

        $todo = $this->getTodoList();

        foreach ($todo as $order_id) {
            echo ". Order::id={$order_id}\n";
            $order = Order::find($order_id);
            $tracking = Tracking::firstOrNew(['order_id' => $order->id]);
            $tracking->track($order);
        }
    }

    /**
     * @return Order[]
     */
    public function getTodoList()
    {
        if ($this->all) {
            return Order::pluck('orders.id');
        }

        return Order::leftJoin('tracking', 'orders.id', '=', 'tracking.order_id')
            ->whereNull('tracking.order_id')
            ->orWhere('tracking.updated_at', '<', DB::raw('orders.updated_at'))
            ->pluck('orders.id');
    }
}
