<?php

namespace App\Updaters;

use App\Models\Project;
use App\Workflows\ChooseProjectFolder;

class UpdateFoldersJob
{
    public function run()
    {
        $todo = Project::whereNull('folder_url')
            ->orWhere('folder_url', '')
            ->get();

        foreach ($todo as $project) {
            $assigned = $this->assignFolder($project);
            if ($assigned) {
                echo ". ({$project->id}) {$project->title}  => {$assigned}\n";
            } else {
                echo "x ({$project->id}) {$project->title}  (could not choose a folder)\n";
            }
        }
    }

    private function assignFolder(Project $project)
    {
        foreach ($project->orders as $order) {
            $cf = new ChooseProjectFolder();
            $assigned = $cf->setFolder($order);
            if ($assigned) {
                return $order->project->folder_name;
            }
        }
        return false;
    }
}
