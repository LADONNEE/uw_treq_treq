<?php
namespace App\Notifications;

use App\Mail\SentBackMail;
use App\Models\Order;
use App\Models\Task;

class SentBackNotifications extends BaseNotification
{
    protected function todo()
    {
        return Task::where('updated_at', '>=', $this->cutoffAfter)
            ->where('updated_at', '<', $this->cutoffBefore)
            ->where('response', Task::RESPONSE_SENTBACK)
            ->whereNull('notified_at')
            ->pluck('id')
            ->all();
    }

    protected function getPendingHeaderItem($id)
    {
        $task = Task::find($id);

        if (!$this->shouldSendTask($task)) {
            return null;
        }


        return new PendingEmailHeader($task->order, "{$task->order->submitter->uwnetid}@uw.edu", 'Order Sent Back');
    }

    public function notifyItem($id)
    {
        $task = Task::find($id);

        if (!$this->shouldSendTask($task)) {
            return;
        }

        $this->sender->send($task->order_id, "{$task->order->submitter->uwnetid}@uw.edu", new SentBackMail($task));
    }

    protected function shouldSendTask($task)
    {
        if (!$task instanceof Task) {
            return false;
        }

        if ($task->notified_at) {
            return false;
        }

        if ($task->response !== Task::RESPONSE_SENTBACK) {
            return false;
        }

        if (!$task->order instanceof Order) {
            return false;
        }

        if (!$task->order->isSentBack()) {
            return false;
        }

        if (!$task->order->submitter) {
            return false;
        }

        return true;
    }
}
