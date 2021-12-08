<?php

namespace App\Reports;

use App\Models\Project;

class OpenTripsReport
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
            ->join('projects_with_preauth_view', 'projects.id', '=', 'projects_with_preauth_view.project_id')
            ->join('trips', 'projects.id', '=', 'trips.project_id')
            ->where('projects.is_travel', 1)
            ->where('trips.return_at', '<', now())
            ->whereNull('projects.closed_at')
            ->orderBy('trips.return_at')
            ->with('trip')
            ->get();
    }
}
