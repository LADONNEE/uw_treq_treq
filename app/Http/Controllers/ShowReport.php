<?php

namespace App\Http\Controllers;

use App\Reports\FoodOrdersReport;
use App\Reports\GiftCardsReport;
use App\Reports\MyOrdersMoreReport;
use App\Reports\OpenTripsReport;
use App\Reports\RecentOrdersReport;
use App\Reports\RspOrdersReport;
use App\Models\Project;
use App\Models\Order;

use Illuminate\Support\Facades\Log;

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

        if (wantsCsv()) {
            $reportdata = $report->load();
            Log::debug('Report DATA');
            Log::debug($slug);
            Log::debug($reportdata);

            return response()->view("reports.{$slug}.csv", compact('reportdata'));                
        }

        return view("reports.{$slug}.index", compact('report'));
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
