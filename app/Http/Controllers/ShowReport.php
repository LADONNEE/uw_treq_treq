<?php

namespace App\Http\Controllers;

use App\Reports\FoodOrdersReport;
use App\Reports\GiftCardsReport;
use App\Reports\MyOrdersMoreReport;
use App\Reports\OpenTripsReport;
use App\Reports\RecentOrdersReport;
use App\Reports\RspOrdersReport;

class ShowReport
{
    private $reports = [
        'food-orders' => FoodOrdersReport::class,
        'gift-cards' => GiftCardsReport::class,
        'my-orders' => MyOrdersMoreReport::class,
        'open-trips' => OpenTripsReport::class,
        'recent' => RecentOrdersReport::class,
        'rsp-orders' => RspOrdersReport::class,
    ];

    public function __invoke($slug)
    {
        $report = $this->load($slug);

        return view("reports.{$slug}", compact('report'));
    }

    private function load($slug)
    {
        if (!isset($this->reports[$slug])) {
            abort(404);
        }

        $classname = $this->reports[$slug];
        return new $classname();
    }
}
