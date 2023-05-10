<?php

namespace App\Reports;

use App\Models\Project;

class PersonOpenTripsReport
{
    public $count = 0;
    public $projects;
    private $person_id;

    public function __construct($person_id)
    {
        $this->person_id = $person_id;
        $this->projects = $this->load();
        $this->count = count($this->projects);
    }

    public function load()
    {
        return Project::select('projects.*')
            ->join('projects_with_preauth_view', 'projects.id', '=', 'projects_with_preauth_view.project_id')
            ->join('trips', 'projects.id', '=', 'trips.project_id')
            ->join('person_trips_view', 'projects.id', '=', 'person_trips_view.project_id')
            ->where('person_trips_view.person_id', 'LIKE', $this->person_id)
            ->where('projects.is_travel', 1)
            ->where('trips.return_at', '<', now())
            ->whereNull('projects.closed_at')
            ->orderBy('trips.return_at')
            ->with('trip')
            ->get();
    }
}
