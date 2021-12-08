<?php
namespace App\Workflows\TaskSteps;

use App\Models\Task;

class NeedsApproval extends OptionalStageStep
{
    public $stage = 'Needs Approval';
    public $taskType = Task::TYPE_APPROVAL;
}
