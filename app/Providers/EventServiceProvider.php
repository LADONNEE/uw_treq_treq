<?php
namespace App\Providers;

use App\AuthNotify\NotifyCollegePerson;
use App\AuthNotify\UserModified;
use App\Events\OrderUpdated;
use App\Events\ProjectUpdated;
use App\Events\StepCompleted;
use App\Events\TaskAddedOrChanged;
use App\Listeners\AssignProjectFolder;
use App\Listeners\AuthorizeApprover;
use App\Listeners\OpenProject;
use App\Listeners\RecordStepCompleted;
use App\Listeners\UpdateTaskWorkflow;
use App\Listeners\UpdateTrackingRecord;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        StepCompleted::class => [
            RecordStepCompleted::class,
        ],
        OrderUpdated::class => [
            OpenProject::class,
            UpdateTaskWorkflow::class,
            UpdateTrackingRecord::class,
        ],
        ProjectUpdated::class => [
            AssignProjectFolder::class,
        ],
        TaskAddedOrChanged::class => [
            AuthorizeApprover::class,
        ],
        UserModified::class => [
            NotifyCollegePerson::class,
        ]
    ];
}
