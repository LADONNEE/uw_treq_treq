<?php
namespace App\Workflows\TaskSteps;

use App\Models\Order;
use App\Utilities\ChooseFiscalContact;

class FiscalContact extends TaskStep
{
    public $stage = Order::STAGE_UNASSIGNED;

    public function activate(): void
    {
        if (!$this->order->assigned_to) {
            $assign_to = (new ChooseFiscalContact())->contactFor($this->order->id);
            if ($assign_to) {
                $this->order->assigned_to = $assign_to;
                $this->order->save();
            }
        }
    }

    public function isComplete(): bool
    {
        return (bool) $this->order->assigned_to;
    }
}
