<?php
namespace App\Http\Controllers;

use App\Events\OrderCanceled;
use App\Models\Note;
use App\Models\Order;
use App\Trackers\LoggedCancel;
use App\Trackers\LoggedNote;
use App\Utilities\PurgeOrder;

class OrderCancelController extends Controller
{
    public function edit(Order $order)
    {
        if (!$order->canCancel(user())) {
            abort(401, 'Not authorized to cancel this order');
        }

        return view('orders.cancel', compact('order'));
    }

    public function update(Order $order)
    {
        if (!$order->canCancel(user())) {
            abort(401, 'Not authorized to cancel this order');
        }

        $cmd = new LoggedCancel($order, user()->person_id);
        $cmd->execute();

        $this->addCancelNote($order, request('note'));

        event(new OrderCanceled($order, user()));

        $this->flash('Order was canceled.', $order);
        return redirect()->route('home');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete');

        $po = new PurgeOrder($order);
        $po->purge();

        $this->flash("Order ({$order->id}) was deleted.");
        return redirect()->route('home');
    }

    private function addCancelNote(Order $order, $note)
    {
        if (!$note) {
            return;
        }

        $cmd = new LoggedNote(new Note(['order_id' => $order->id]), user()->person_id, $note);
        $cmd->shouldLog = $order->shouldLog();
        $cmd->execute();
    }
}
