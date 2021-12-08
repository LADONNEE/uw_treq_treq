<?php

namespace App\Console\Commands;

use App\Models\UserFolder;
use Illuminate\Console\Command;

class FolderNames extends Command
{
    protected $signature = 'folder:names';

    protected $description = 'Generate short names for user folder OneDrive URLs';

    public function handle()
    {
        $folders = UserFolder::get();

        foreach ($folders as $folder) {
            $folder->generateShortName();
            $folder->save();

            echo " . ({$folder->id}) {$folder->name}\n";
        }
    }
}
