<?php
namespace App\Notifications;

use App\Models\Order;
use App\Models\Task;
use App\Utilities\MailSender;
use Carbon\Carbon;

abstract class BaseNotification
{
    protected $cutoffAfter;
    protected $cutoffBefore;
    protected $sender;

    public function __construct(MailSender $sender, Carbon $cutoffAfter, Carbon $cutoffBefore)
    {
        $this->cutoffAfter = $cutoffAfter;
        $this->cutoffBefore = $cutoffBefore;
        $this->sender = $sender;
    }

    /**
     * Provide a header object for a single notification item
     * @param mixed $item
     * @return PendingEmailHeader|null
     */
    abstract protected function getPendingHeaderItem($item);

    /**
     * Provide a list of items that need notifications sent
     * @return mixed
     */
    abstract protected function todo();

    /**
     * Process single item provided by todo() method
     * @param mixed $item
     * @return mixed
     */
    abstract public function notifyItem($item);

    /**
     * Return brief headers for each to-do item
     * Support preview of pending email messages
     * @return PendingEmailHeader[]
     */
    public function getPendingHeaders()
    {
        $out = [];
        $items = $this->todo();

        foreach ($items as $id) {
            $h = $this->getPendingHeaderItem($id);
            if ($h instanceof PendingEmailHeader) {
                $out[] = $h;
            }
        }
        return $out;
    }

    public function run()
    {
        $items = $this->todo();

        foreach ($items as $id) {
            $this->notifyItem($id);
        }
    }

    protected function shouldSendOrder($order)
    {
        if (!$order instanceof Order) {
            return false;
        }

        if ($order->notified_at) {
            return false;
        }

        if (!$order->submitted_by || !$order->submitter) {
            return false;
        }

        return true;
    }

    protected function shouldSendTask($task)
    {
        if (!$task instanceof Task) {
            return false;
        }

        if ($task->notified_at) {
            return false;
        }

        if ($task->completed_at) {
            return false;
        }

        if (!$task->order instanceof Order) {
            return false;
        }

        if ($task->order->isComplete() || $task->order->isCanceled()) {
            return false;
        }

        return true;
    }
}
