<?php

namespace App\Http\Controllers;

use App\Events\StepCompleted;
use App\Models\Order;

class AttachmentsController extends Controller
{
    public function edit(Order $order)
    {
        return view('attachments.edit', compact('order'));
    }

    public function update(Order $order)
    {
        event(new StepCompleted($order, 'attachments', user()));

        return redirect()->route('next', $order->id);
    }
}
