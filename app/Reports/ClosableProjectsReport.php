<?php

namespace App\Reports;

use App\Models\Project;

class ClosableProjectsReport
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
            ->join('projects_closable_view', 'projects.id', '=', 'projects_closable_view.project_id')
            ->leftJoin('trips', 'projects.id', '=', 'trips.project_id')
            ->whereNull('closed_at')
            ->where(function ($query) {
                $query->whereNull('trips.return_at')
                    ->orWhere('trips.return_at', '<', now()->subDays(60));
            })
            ->orderBy('projects.created_at', 'desc')
            ->with('trip')
            ->get();
    }
}
