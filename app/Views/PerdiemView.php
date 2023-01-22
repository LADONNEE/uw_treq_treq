<?php

namespace App\Views;

use App\Models\Order;
use App\Models\Perdiem;

class PerdiemView
{
    public $lodging;
    public $lodgingDetail;
    public $meals;
    public $mealsDetail;

    public function __construct(Order $order)
    {
        if ($order->perdiem) {
            $this->lodging = $order->perdiem->lodging;
            $this->lodgingDetail = $this->makeLodgingDetail($order->perdiem);
            $this->meals = (int) $order->perdiem->meals . '.00';
            $this->mealsDetail = $this->makeMealDetail($order->perdiem);
        } else {
            $this->lodging = '0.00';
            $this->lodgingDetail = 'none';
            $this->meals = '0.00';
            $this->mealsDetail = 'none';
        }
    }

    private function makeLodgingDetail(Perdiem $perdiem)
    {
        $numNights = (int) $perdiem->nights;
        $lodging_pd = (int) $perdiem->lodging_pd;
        $lodgingLimit = $numNights * $lodging_pd;
        $nights = ($numNights === 1) ? '1 night' : "{$numNights} nights";
        return "limit \${$lodgingLimit} = {$nights} &times; \${$lodging_pd}";
    }

    private function makeMealDetail(Perdiem $perdiem)
    {
        $numDays = (int) $perdiem->days;
        $meals_pd = (int) $perdiem->meals_pd;
        $meals_estimated_total = $numDays * $meals_pd ?? 0;
        $days = ($numDays === 1) ? '1 night' : "{$numDays} days";
        return "\${$meals_estimated_total} = {$days} &times; \${$meals_pd}";
    }
}
