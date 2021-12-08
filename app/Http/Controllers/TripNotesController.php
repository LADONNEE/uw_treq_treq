<?php
namespace App\Http\Controllers;

use App\Forms\TripNotesForm;
use App\Models\Order;

class TripNotesController extends Controller
{
    public function edit(Order $order)
    {
        $this->canIEdit($order, 'trip_notes');

        $form = new TripNotesForm($order);

        return view('trip-notes.edit', compact('order', 'form'));
    }

    public function update(Order $order)
    {
        $this->canIEdit($order, 'trip_notes');

        $form = new TripNotesForm($order);
        if ($form->process()) {
            return redirect()->route('next', $order->id);
        }

        return redirect()->back();
    }
}
