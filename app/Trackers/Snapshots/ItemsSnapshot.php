<?php
namespace App\Trackers\Snapshots;

use App\Models\Order;

class ItemsSnapshot extends SnapshotList
{
    public function __construct(Order $order)
    {
        $order = $order->fresh();
        foreach ($order->items as $item) {
            $this->addItem($item->name, $item->amount);
        }
    }

    public function getItemLabel(): string
    {
        return 'items';
    }
}
