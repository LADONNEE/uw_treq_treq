<?php

namespace App\Http\Controllers;

use App\Forms\ResubmitForm;
use App\Models\Order;

class ResubmitController extends Controller
{
    public function edit(Order $order)
    {
        if ($order->isSubmitted()) {
            $this->flash('This order is already submitted. It cannot be re-submitted.');
            return redirect()->route('order', $order->id);
        }

        if (!$order->isSentBack()) {
            return redirect()->route('department', $order->id);
        }

        $form = new ResubmitForm($order);

        return view('resubmit.edit', compact('order', 'form'));
    }

    public function update(Order $order)
    {
        $form = new ResubmitForm($order);

        if ($form->process()) {
            return redirect()->route('order', $order->id);
        }

        return redirect()->back();
    }
}
