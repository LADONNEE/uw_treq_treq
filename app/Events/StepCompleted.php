<?php
namespace App\Events;

use App\Auth\User;
use App\Models\Order;

class StepCompleted
{
    public $order;
    public $step;
    public $user;

    public function __construct(Order $order, $step, User $user)
    {
        $this->order = $order;
        $this->step = $step;
        $this->user = $user;
    }
}
