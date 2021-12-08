<?php
namespace App\Notifications;

use App\Mail\OrderCanceledMail;
use App\Models\Order;

class CanceledNotification extends BaseNotification
{
    protected function todo()
    {
        return Order::where('updated_at', '>=', $this->cutoffAfter)
            ->where('updated_at', '<', $this->cutoffBefore)
            ->where('stage', Order::STAGE_CANCELED)
            ->whereNull('notified_at')
            ->pluck('id')
            ->all();
    }

    protected function getPendingHeaderItem($id)
    {
        $order = Order::find($id);

        if (!$this->shouldSendTask($order)) {
            return null;
        }

        return new PendingEmailHeader($order, "{$order->submitter->uwnetid}@uw.edu", 'Order Canceled');
    }

    public function notifyItem($id)
    {
        $order = Order::find($id);

        if (!$this->shouldSendOrder($order)) {
            return;
        }

        $this->sender->send($order->id, "{$order->submitter->uwnetid}@uw.edu", new OrderCanceledMail($order));
    }
}
