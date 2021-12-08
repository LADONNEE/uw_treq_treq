<?php
namespace App\Listeners;

use App\Events\ProjectUpdated;
use App\Workflows\ChooseProjectFolder;

class AssignProjectFolder
{
    public function handle(ProjectUpdated $event)
    {
        if (!$event->project->folder_url) {
            $event->order->load('project');
            $ch = new ChooseProjectFolder();
            $ch->setFolder($event->order);
        }
    }
}
