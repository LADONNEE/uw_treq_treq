<?php
namespace App\Workflows\TaskSteps;

use App\Models\Task;

class EnterInAriba extends SimpleTaskStep
{
    public $stage = 'Enter in Ariba';
    public $taskType = Task::TYPE_ARIBA;
}
