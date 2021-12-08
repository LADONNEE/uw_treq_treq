<?php
namespace App\Listeners;

use App\Events\OrderUpdated;

class UpdateTrackingRecord
{
    public function handle(OrderUpdated $event)
    {
        $event->getOrder()->updateTracking();
    }
}
