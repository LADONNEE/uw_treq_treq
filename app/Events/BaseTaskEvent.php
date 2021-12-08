<?php

namespace App\Events;

use App\Auth\User;
use App\Models\Order;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class BaseTaskEvent implements OrderUpdated, TaskAddedOrChanged
{
    public $task;
    public $user;

    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    public function getOrder(): Order
    {
        return $this->task->order;
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
