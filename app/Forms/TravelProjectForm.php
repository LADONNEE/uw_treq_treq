<?php
namespace App\Forms;

use App\Events\ProjectUpdated;
use App\Events\StepCompleted;
use App\Forms\Validators\PersonExists;
use App\Models\Order;
use App\Models\Person;
use App\Models\Trip;
use App\Trackers\LoggedTravel;
use Uworgws\Formkit\ValueHandlers\CarbonDateValue;
use Carbon\Carbon;

class TravelProjectForm extends ProjectForm
{
    private $trip;

    public function __construct(Order $order)
    {
        parent::__construct($order);
        $this->trip = $this->project->trip ?? new Trip();
    }

    public function createInputs()
    {
        parent::createInputs();

        $this->add('traveler_type', 'radio')
            ->options([
                'uworg' => 'UWORG Traveler (Staff, Student, Faculty)',
                'uw' => 'UW Traveler (Other Unit)',
                'non_uw' => 'Non UW Traveler',
            ]);

        $this->add('person_id', 'hidden')
            ->set('id', 'js-traveler-person-id');
        $this->add('traveler_search')
            ->class('person-typeahead')
            ->set('data-for', 'js-traveler-person-id');

        $this->add('traveler');
        $this->add('traveler_email');
        $this->add('traveler_phone');
        $this->add('destination');
        $this->add('state');
        $this->add('depart_at', 'date', new CarbonDateValue());
        $this->add('return_at', 'date', new CarbonDateValue());
        $this->add('depart_at_time', 'time', new CarbonDateValue('g:i A'));
        $this->add('return_at_time', 'time', new CarbonDateValue('g:i A'));
        $this->add('personal_time', 'boolean')
            ->set('booleanText', 'Will use time-off during trip');
        $this->add('personal_time_dates');
        $this->add('has_honorarium', 'boolean');
        $this->add('honorarium');
        $this->add('nuwt_address_line1');
        $this->add('nuwt_address_line2');
        $this->add('nuwt_city');
        $this->add('nuwt_state_province');
        $this->add('nuwt_zipcode');
        $this->add('nuwt_country');
    }

    public function initValues()
    {
        parent::initValues();

        $this->fill($this->trip);
        $this->fill([
            'traveler_type' => $this->travelerType(),
            'traveler_search' => ($this->trip->person_id) ? $this->trip->traveler : '',
            'has_honorarium' => (bool) $this->trip->honorarium,
            'selectedstate' => $this->trip->state,
            'depart_at' => $this->trip->depart_at,
            'return_at' => $this->trip->return_at,
            'depart_at_time' => $this->trip->depart_at_time,
            'return_at_time' => $this->trip->return_at_time,
            'depart_at_time' => $this->trip->depart_at_time ? Carbon::parse($this->trip->depart_at_time)->format('g:i A') : '',
            'return_at_time' => $this->trip->depart_at_time ? Carbon::parse($this->trip->return_at_time)->format('g:i A') : '',
            'nuwt_address_line1' => $this->trip->nuwt_address_line1,
            'nuwt_address_line2' => $this->trip->nuwt_address_line2,
            'nuwt_city' => $this->trip->nuwt_city,
            'nuwt_state_province' => $this->trip->nuwt_state_province,
            'nuwt_zipcode' => $this->trip->nuwt_zipcode,
            'nuwt_country' => $this->trip->nuwt_country,
        ]);

        if (!$this->trip->exists) {
            $user = user();
            $this->fill([
                'person_id' => $user->person_id,
                'traveler_search' => "{$user->firstname} {$user->lastname}",
            ]);
        }
    }

    private function travelerType()
    {
        if (!$this->trip->exists || $this->trip->person_id) {
            return 'uworg';
        }
        return ($this->trip->non_uw) ? 'non_uw' :  'uw';
    }

    public function validate()
    {
        parent::validate();

        $this->check('traveler_type')->inList();
        $this->check('destination')->notEmpty();
        //$this->check('state')->notEmpty();

        if ($this->value('traveler_type') === 'uworg') {
            $person = Person::find($this->value('person_id'));
            if (!$person instanceof Person) {
                $this->input('traveler_search')->error('Unknown person, select from suggestions');
            }
        } else {
            $this->check('traveler')->notEmpty();
            $this->check('traveler_email')->notEmpty();
        }

        if ($this->value('personal_time')) {
            $this->check('personal_time_dates')->notEmpty();
        }
    }

    public function commit()
    {
        $cmd = new LoggedTravel(
            $this->order,
            $this->project,
            $this->trip,
            $this->value('purpose'),
            $this->tripData(),
            user()->person_id
        );
        $cmd->shouldLog = $this->order->shouldLog();
        $cmd->execute();

        event(new StepCompleted($this->order, 'trip', user()));
        event(new ProjectUpdated($this->project, $this->order, user()));
    }

    private function tripData()
    {
        $type = $this->value('traveler_type');

        $out = [
            'destination' => $this->value('destination'),
            'state' => $this->value('state'),
            'depart_at' => $this->value('depart_at'),
            'return_at' => $this->value('return_at'),
            'depart_at_time' => $this->value('depart_at_time'),
            'return_at_time' => $this->value('return_at_time'),
            'traveler' => $this->value('traveler'),
            'person_id' => $this->value('person_id'),
            'relevance' => $this->value('relevance'),
            'arrangement' => $this->value('arrangement'),
            'traveler_email' => $this->value('traveler_email'),
            'traveler_phone' => $this->value('traveler_phone'),
            'non_uw' => ($type === 'non_uw'),
            'personal_time' => $this->value('personal_time'),
            'personal_time_dates' => null,
            'honorarium' => null,
            'nuwt_address_line1' => $this->value('nuwt_address_line1'),
            'nuwt_address_line2' => $this->value('nuwt_address_line2'),
            'nuwt_city' => $this->value('nuwt_city'),
            'nuwt_state_province' => $this->value('nuwt_state_province'),
            'nuwt_zipcode' => $this->value('nuwt_zipcode'),
            'nuwt_country' => $this->value('nuwt_country'),
        ];

        if ($type === 'uworg') {
            $p = Person::find($out['person_id']);
            if ($p instanceof Person) {
                $out['traveler'] = "{$p->firstname} {$p->lastname}";
                $out['traveler_email'] = ($p->uwnetid) ? "{$p->uwnetid}@uw.edu" : null;
                $out['non_uw'] = false;
            }
        } else {
            $out['person_id'] = null;
        }

        if ($this->value('personal_time')) {
            $out['personal_time_dates'] = $this->value('personal_time_dates');
        }

        if ($type === 'non_uw' && $this->value('has_honorarium')) {
            $out['honorarium'] = $this->value('honorarium');
        }

        return $out;
    }
}
