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
            'depart time' => Snap::time($trip->depart_at_time),
            'return time' => Snap::time($trip->return_at_time),
            'non uw traveler' => Snap::yesNo($trip->non_uw),
            'traveler' => Snap::text($trip->traveler),
            'uworg traveler' => Snap::personId($trip->person_id),
            'email' => Snap::text($trip->traveler_email),
            'phone' => Snap::text($trip->traveler_phone),
            'personal time' => Snap::yesNo($trip->personal_time),
            'pt dates' => Snap::text($trip->personal_time_dates),
            'honorarium' => Snap::text($trip->honorarium),
            'nuwt_address_line1' => Snap::text($trip->nuwt_address_line1),
            'nuwt_address_line2' => Snap::text($trip->nuwt_address_line2),
            'nuwt_city' => Snap::text($trip->nuwt_city),
            'nuwt_state_province' => Snap::text($trip->nuwt_state_province),
            'nuwt_zipcode' => Snap::text($trip->nuwt_zipcode),
            'nuwt_country' => Snap::text($trip->nuwt_country),
        ];
    }

    public function getItemLabel(): string
    {
        return 'trip';
    }
}
