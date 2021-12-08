<?php
namespace App\Listeners;

use App\Events\OrderUpdated;
use App\Workflows\TaskWorkflow;

class UpdateTaskWorkflow
{
    private $workflow;

    public function __construct(TaskWorkflow $workflow)
    {
        $this->workflow = $workflow;
    }

    public function handle(OrderUpdated $event)
    {
        $this->workflow->update($event->getOrder());
    }
}
