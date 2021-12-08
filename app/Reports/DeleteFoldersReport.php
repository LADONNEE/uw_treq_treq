<?php

namespace App\Reports;

use App\Models\Project;

class DeleteFoldersReport
{
    public $count = 0;
    public $projects;

    public function __construct()
    {
        $this->projects = $this->load();
        $this->count = count($this->projects);
    }

    public function load()
    {
        return Project::select('projects.*')
            ->whereNull('folder_deleted')
            ->where('closed_at', '<', now()->subDays(90))
            ->orderBy('closed_at', 'desc')
            ->with('trip')
            ->get();
    }
}
