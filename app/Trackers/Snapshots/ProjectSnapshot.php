<?php
namespace App\Trackers\Snapshots;

use App\Models\Project;

class ProjectSnapshot extends Snapshot
{
    public function __construct(Project $project)
    {
        $this->state = [
            'title' => Snap::text($project->title),
            'owner' => Snap::personId($project->person_id),
            'purpose' => Snap::truncate($project->purpose),
            'food' => Snap::yesNo($project->is_food),
            'gift card' => Snap::yesNo($project->is_gift_card),
            'rsp' => Snap::yesNo($project->is_rsp),
        ];
    }

    public function getItemLabel(): string
    {
        return 'project';
    }
}
