<?php
namespace App\Http\Controllers;

use App\Forms\TripNotesForm;
use App\Models\Order;
use App\Models\Question;

class TripNotesController extends Controller
{
    public function edit(Order $order)
    {
        $this->canIEdit($order, 'trip_notes');

        $form = new TripNotesForm($order);

        $questions = Question::all();
        return view('trip-notes.edit', compact('order', 'form', 'questions'));
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
