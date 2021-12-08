<?php

namespace App\Console\Commands;

use App\Updaters\UpdateTrackingJob;
use Illuminate\Console\Command;

class UpdateTracking extends Command
{
    protected $signature = 'update:tracking {--all : regenerate tracking for all records}';

    protected $description = 'Update denormalize tracking records: last action, next action.';

    public function handle()
    {
        $job = new UpdateTrackingJob($this->option('all'));
        $job->run();
    }
}
