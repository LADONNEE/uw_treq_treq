<?php
namespace App\Http\Controllers;

use App\Events\StepCompleted;
use App\Models\Order;
use App\Trackers\LoggedItems;

class ItemsController extends Controller
{
    public function edit(Order $order)
    {
        $this->canIEdit($order, 'items');

        return view('items.edit', compact('order'));
    }

    public function update(Order $order)
    {
        $this->canIEdit($order, 'items');

        $cmd = new LoggedItems($order, request('items_json'), user()->person_id);
        $cmd->shouldLog = $order->shouldLog();
        $cmd->execute();

        event(new StepCompleted($order, 'items', user()));

        return redirect()->route('next', $order->id);
    }
}
