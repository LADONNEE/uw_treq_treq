<?php

namespace App\Forms;

use App\Events\StepCompleted;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\TripNotesCollection;

class TripNotesForm extends Form
{
    private $order;
    private $notes;

    public $itemNames = [];

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->notes = new TripNotesCollection($order->id);
        foreach ($this->notes->notes as $tn) {
            $this->itemNames[] = $tn->item;
        }
    }

    public function createInputs()
    {
        foreach ($this->notes->notes as $tn) {
            $this->add($tn->item, 'radio')
                ->label($tn->question)
                ->options(['Y' => 'Yes', 'N' => 'No']);
            if ($tn->options) {
                $this->add("{$tn->item}_note", 'radio')
                    ->label('You must upload documentation supporting the specific exemption you are choosing in your OneDrive folder:')
                    ->options(array_to_options($tn->options));
            } else {
                $this->add("{$tn->item}_note", 'textarea')
                    ->label('Please describe');
            }
        }
    }

    public function initValues()
    {
        foreach ($this->notes->notes as $tn) {
            $this->fill([
                $tn->item => $tn->answer,
                "{$tn->item}_note" => $tn->note,
            ]);
        }
    }

    public function validate()
    {
        foreach ($this->notes->notes as $tn) {
            $this->check($tn->item)->inList()->notEmpty('Answer required');
            $isYes = $this->value($tn->item) === 'Y';
            if ($isYes) {
                $noteInput = $this->input("{$tn->item}_note");
                if ($noteInput->getType() === 'radio') {
                    $this->check($noteInput->getName())->inList()->notEmpty();
                } else {
                    $this->check($noteInput->getName())->notEmpty();
                }
            }
        }
    }

    public function commit()
    {
        foreach ($this->notes->notes as $tn) {
            $tn->save($this->value($tn->item), $this->value("{$tn->item}_note"));
        }

        if ($this->order->shouldLog()) {
            $this->writeLog();
        }

        event(new StepCompleted($this->order, 'trip-notes', user()));
    }

    private function writeLog()
    {
        $messages = [];
        foreach ($this->notes->notes as $tn) {
            if ($tn->wasModified) {
                $messages[] = $tn->logMessage;
            }
        }
        if (!$messages) {
            return;
        }

        $log = new OrderLog([
            'order_id' => $this->order->id,
            'actor_id' => user()->person_id,
            'project_id' => null,
            'message' => 'updated trip notes. ' . implode(', ', $messages),
        ]);
        $log->save();
    }
}
