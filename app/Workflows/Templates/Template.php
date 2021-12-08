<?php
namespace App\Workflows\Templates;

use App\Workflows\TaskSteps\Canceled;
use App\Workflows\TaskSteps\Creating;
use App\Workflows\TaskSteps\NeedsApproval;
use App\Workflows\TaskSteps\PendingTask;
use App\Workflows\TaskSteps\ProjectFolder;
use App\Workflows\TaskSteps\Resubmitted;
use App\Workflows\TaskSteps\SentBack;

abstract class Template
{
    abstract public function requestSteps(): array;

    abstract public function taskSteps(): array;

    /**
     * Combine the specific tasks for the workflow type with
     * standard task/stages that any request type can go through
     * @return array
     */
    public function allTaskSteps(): array
    {
        return array_merge([
            Canceled::class,
            SentBack::class,
            Creating::class,
            Resubmitted::class,
            NeedsApproval::class,
            PendingTask::class,
        ], $this->taskSteps());
    }
}
