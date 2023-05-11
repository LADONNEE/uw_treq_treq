<?php

namespace App\Reports;

use App\Auth\User;

class HomeCollection
{
    private $user;

    private $reportClasses = [
        'tasks' => MyTasksReport::class,
        'creating' => MyCreatingReport::class,
        'myOrders' => MyOrdersReport::class,
        'myTrips' => MyTripsReport::class,
        'onCall' => OnCallOrders::class,
        'pending' => PendingOrders::class,
        'complete' => CompleteOrders::class,
    ];
    private $reportInstances = [];

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        if (!isset($this->reportInstances[$name])) {
            $classname = $this->reportClasses[$name];
            $this->reportInstances[$name] = new $classname($this->user->person_id);
        }
        return $this->reportInstances[$name];
    }

}
