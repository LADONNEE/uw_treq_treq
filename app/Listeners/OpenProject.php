<?php
namespace App\Listeners;

use App\Events\OrderUpdated;

class OpenProject
{
    public function handle(OrderUpdated $event)
    {
        $order = $event->getOrder();

        if (!$order->isComplete() && !$order->isCanceled()) {
            $order->project->open();
        }
    }
}
