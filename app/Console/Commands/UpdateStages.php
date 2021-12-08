<?php

namespace App\Console\Commands;

use App\Updaters\UpdateStagesJob;
use Illuminate\Console\Command;

class UpdateStages extends Command
{
    protected $signature = 'update:stages';

    protected $description = 'Update database map of Order::$stage to Task::$type';

    public function handle()
    {
        $job = new UpdateStagesJob();
        $job->run();
    }
}
