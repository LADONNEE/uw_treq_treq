<?php

namespace App\Console\Commands;

use App\Updaters\UpdateFoldersJob;
use Illuminate\Console\Command;

class UpdateFolders extends Command
{
    protected $signature = 'update:folders';

    protected $description = 'Fill folder_name property on projects that have empty value';

    public function handle()
    {
        $job = new UpdateFoldersJob();
        $job->run();
    }
}
