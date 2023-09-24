<?php
namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $project_id
 * @property string   $destination
 * @property string   $state
 * @property Carbon   $depart_at
 * @property Carbon   $return_at
 * @property string   $traveler
 * @property integer  $person_id
 * @property string   $traveler_email
 * @property string   $traveler_phone
 * @property boolean  $non_uw
 * @property boolean  $personal_time
 * @property string   $personal_time_dates
 * @property string   $honorarium
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 * @property Project $project
 */
class Trip extends Model
{
    protected $table = 'trips';
    protected $fillable = [
        'project_id',
        'destination',
        'state',
        'depart_at',
        'return_at',
        'depart_at_time',
        'return_at_time',
        'traveler',
        'person_id',
        'traveler_email',
        'traveler_phone',
        'non_uw',
        'personal_time',
        'personal_time_dates',
        'honorarium',
        'nuwt_address_line1',
        'nuwt_address_line2',
        'nuwt_city',
        'nuwt_state_province',
        'nuwt_zipcode',
        'nuwt_country',
    ];
    protected $casts = [
        'depart_at',
        'return_at',
        'created_at',
        'updated_at',
    ];

    public function travelerLastName()
    {
        if ($this->person_id) {
            $person = Person::find($this->person_id);
            return ($person) ? $person->lastname : 'unknown';
        }
        $words = explode(' ', $this->traveler);
        $last = array_pop($words);
        return ($last) ?: 'unknown';
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
