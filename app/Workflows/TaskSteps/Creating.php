<?php
namespace App\Workflows\TaskSteps;

use App\Models\Order;

class Creating extends TaskStep
{
    public $stage = Order::STAGE_CREATING;

    public function activate(): void
    {
        // do nothing
    }

    public function isComplete(): bool
    {
        return $this->order->isSubmitted();
    }
}
