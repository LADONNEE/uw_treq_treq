<?php

namespace App\Reports;

/**
 * Wrapper for MyOrdersReport, change period to 2 years
 * Adjust load() behavior for ShowReports
 */
class MyOrdersMoreReport extends OrdersReport
{
    public function load()
    {
        $mo = new MyOrdersReport(user()->person_id, 730);
        return $mo->orders;
    }
}
