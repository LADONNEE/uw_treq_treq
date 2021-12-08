<?php

namespace Tests\Trackers\Snapshots;

use App\Trackers\Snapshots\SnapDate;
use Carbon\Carbon;
use Tests\TestCase;

class SnapDateTest extends TestCase
{
    public function test_it_instantiates()
    {
        $it = new SnapDate(null);

        $this->assertInstanceOf(SnapDate::class, $it);
    }

    public function test_values_that_are_not_carbon_dates_are_stored_as_string()
    {
        $it = new SnapDate('hello');

        $this->assertSame('hello', $it->value);
    }

    public function test_dates_are_stored_as_formatted_string()
    {
        $date = Carbon::createFromDate(2020, 05, 01);
        $it = new SnapDate($date);

        $this->assertSame('5/1/2020', $it->value);
    }

    public function test_format_returns_the_value()
    {
        $date = Carbon::createFromDate(2020, 05, 01);
        $it = new SnapDate($date);

        $this->assertSame('5/1/2020', $it->format());
    }
}
