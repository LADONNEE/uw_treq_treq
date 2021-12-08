<?php
namespace App\Workflows\TaskSteps;

use App\Models\Order;
use App\Models\Task;

class Resubmitted extends OptionalStageStep
{
    public $stage = Order::STAGE_RESUBMITTED;
    public $taskType = Task::TYPE_RESUBMIT;
}
