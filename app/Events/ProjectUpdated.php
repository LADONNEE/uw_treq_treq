<?php
namespace App\Events;

use App\Auth\User;
use App\Models\Order;
use App\Models\Project;

class ProjectUpdated
{
    public $order;
    public $project;
    public $user;

    public function __construct(Project $project, Order $order, User $user)
    {
        $this->order = $order;
        $this->project = $project;
        $this->user = $user;
    }
}
