<?php
namespace App\Forms;

use App\Events\ProjectUpdated;
use App\Events\StepCompleted;
use App\Forms\Validators\PersonExists;
use App\Models\Order;
use App\Models\Person;
use App\Models\Trip;
use App\Trackers\LoggedTravel;
use Uwcoenvws\Formkit\ValueHandlers\CarbonDateValue;

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
                'coenv' => 'COENV Traveler (Faculty, Staff, Student)',
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
        $this->add('depart_at', 'text', new CarbonDateValue());
        $this->add('return_at', 'text', new CarbonDateValue());
        $this->add('personal_time', 'boolean')
            ->set('booleanText', 'Will use time-off during trip');
        $this->add('personal_time_dates');
        $this->add('has_honorarium', 'boolean');
        $this->add('honorarium');
    }

    public function initValues()
    {
        parent::initValues();

        $this->fill($this->trip);
        $this->fill([
            'traveler_type' => $this->travelerType(),
            'traveler_search' => ($this->trip->person_id) ? $this->trip->traveler : '',
            'has_honorarium' => (bool) $this->trip->honorarium,
            'depart_at' => $this->trip->depart_at,
            'return_at' => $this->trip->return_at,
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
            return 'coenv';
        }
        return ($this->trip->non_uw) ? 'non_uw' :  'uw';
    }

    public function validate()
    {
        parent::validate();

        $this->check('traveler_type')->inList();
        $this->check('destination')->notEmpty();

        if ($this->value('traveler_type') === 'coenv') {
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
            'depart_at' => $this->value('depart_at'),
            'return_at' => $this->value('return_at'),
            'traveler' => $this->value('traveler'),
            'person_id' => $this->value('person_id'),
            'traveler_email' => $this->value('traveler_email'),
            'traveler_phone' => $this->value('traveler_phone'),
            'non_uw' => ($type === 'non_uw'),
            'personal_time' => $this->value('personal_time'),
            'personal_time_dates' => null,
            'honorarium' => null,
        ];

        if ($type === 'coenv') {
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