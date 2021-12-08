<?php
namespace App\Listeners;

use App\Events\StepCompleted;
use App\Repositories\ProgressRepository;
use App\Workflows\RequestWorkflow;

class RecordStepCompleted
{
    private $repo;

    public function __construct(ProgressRepository $repo)
    {
        $this->repo = $repo;
    }

    public function handle(StepCompleted $event)
    {
        $progress = new RequestWorkflow($this->repo);
        $progress->complete($event);
    }
}
