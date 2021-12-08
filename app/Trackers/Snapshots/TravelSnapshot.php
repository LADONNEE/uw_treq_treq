<?php
namespace App\Trackers\Snapshots;

use App\Models\Project;
use App\Models\Trip;

class TravelSnapshot extends Snapshot
{
    public function __construct(Project $project, Trip $trip)
    {
        $this->state = [
            'purpose' => Snap::truncate($project->purpose),
            'depart' => Snap::date($trip->depart_at),
            'return' => Snap::date($trip->return_at),
            'non uw traveler' => Snap::yesNo($trip->non_uw),
            'traveler' => Snap::text($trip->traveler),
            'coe traveler' => Snap::personId($trip->person_id),
            'email' => Snap::text($trip->traveler_email),
            'phone' => Snap::text($trip->traveler_phone),
            'personal time' => Snap::yesNo($trip->personal_time),
            'pt dates' => Snap::text($trip->personal_time_dates),
            'honorarium' => Snap::text($trip->honorarium),
        ];
    }

    public function getItemLabel(): string
    {
        return 'trip';
    }
}
