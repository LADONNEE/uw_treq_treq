<?php

namespace App\Forms;

use App\Events\OrderResubmitted;
use App\Models\Order;
use App\Utilities\ChooseFiscalContact;
use App\Workflows\ResubmitWorkflow;

class ResubmitForm extends Form
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function createInputs()
    {
        $this->add('description', 'textarea');
    }

    public function validate()
    {
        // No validation needed
    }

    public function commit()
    {
        $wf = new ResubmitWorkflow($this->order, $this->value('description'), user()->person_id);
        $wf->resubmit();

        event(new OrderResubmitted($this->order, user()));
    }
}
