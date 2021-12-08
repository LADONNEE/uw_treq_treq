<?php

namespace App\Reports;

use App\Models\Project;

class TripFollowUpReport
{
    public $count = 0;
    public $projects;

    protected $person_id;

    public function __construct($person_id)
    {
        $this->person_id = $person_id;
        $this->projects = $this->load();
        $this->count = count($this->projects);
    }

    public function load()
    {
        return Project::select('projects.*')
            ->join('person_trips_view', 'projects.id', '=', 'person_trips_view.project_id')
            ->where('person_trips_view.person_id', $this->person_id)
            ->where('person_trips_view.return_at', '>', now()->subYear())
            ->orderBy('projects.created_at', 'desc')
            ->with('trip')
            ->get();
    }
}
