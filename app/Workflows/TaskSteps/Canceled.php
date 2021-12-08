<?php
namespace App\Workflows\TaskSteps;

use App\Models\Order;

class Canceled extends TaskStep
{
    public $stage = Order::STAGE_CANCELED;

    public function getTaskType(): string
    {
        return '';
    }

    public function activate(): void
    {
        // do nothing
    }

    public function isComplete(): bool
    {
        return ! $this->order->isCanceled();
    }
}
