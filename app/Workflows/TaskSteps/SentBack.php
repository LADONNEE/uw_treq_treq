<?php
namespace App\Workflows\TaskSteps;

use App\Models\Order;

class SentBack extends TaskStep
{
    public $stage = Order::STAGE_SENT_BACK;

    public function activate(): void
    {
        // do nothing
    }

    public function isComplete(): bool
    {
        return ! $this->order->isSentBack();
    }
}
