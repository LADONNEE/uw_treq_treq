<?php
namespace App\Forms;

use App\Forms\Validators\PersonExists;
use App\Models\Order;
use App\Models\OrderLog;

class AssignFiscalForm extends Form
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function createInputs()
    {
        $this->add('person_id', 'hidden')
            ->set('id', 'js-assign-person-id');
        $this->add('assign_search')
            ->class('person-typeahead')
            ->set('data-for', 'js-assign-person-id');
    }

    public function initValues()
    {
        if ($this->order->assigned_to) {
            $this->fill([
                'person_id' => $this->order->assigned_to,
                'assign_search' => eFirstLast($this->order->assignee),
            ]);
        }
    }

    public function validate()
    {
        $this->check('person_id')->using(new PersonExists());
    }

    public function commit()
    {
        $this->order->assigned_to = $this->value('person_id');
        $this->order->save();

        $log = new OrderLog([
            'order_id' => $this->order->id,
            'actor_id' => user()->person_id,
            'message' => 'assigned fiscal contact ' . eFirstLast($this->order->assigned_to),
        ]);
        $log->save();
    }
}
