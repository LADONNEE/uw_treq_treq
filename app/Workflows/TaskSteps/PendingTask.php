<?php
namespace App\Workflows\TaskSteps;

use App\Models\Task;

class PendingTask extends OptionalStageStep
{
    public $stage = 'Pending Task';
    public $taskType = Task::TYPE_TASK;
}
