<?php
namespace App\Workflows\TaskSteps;

use App\Models\Task;

class PlaceOrder extends SimpleTaskStep
{
    public $stage = 'Place Order';
    public $taskType = Task::TYPE_ORDER;
}
