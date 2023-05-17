<?php
namespace App\Http\Controllers;

use App\Forms\TravelProjectForm;
use App\Models\Order;
use App\Models\State;

class TripsController extends Controller
{
    public function create($type)
    {
        $states = State::orderBy('id')->get();
        $selectedstate = '';
        $order = new Order(['type' => $type]);
        $form = new TravelProjectForm($order);

        return view('trips.create', compact('order', 'form', 'states', 'selectedstate'));
    }

    public function store($type)
    {
        $order = new Order(['type' => $type]);

        $form = new TravelProjectForm($order);

        if ($form->process()) {
            return redirect()->route('next', $order->id);
        }

        return redirect()->back();
    }

    public function edit(Order $order)
    {
        $this->canIEdit($order, 'project');
        $states = State::orderBy('id')->get();
        $selectedstate = $order->project->trip?->state;

        $form = new TravelProjectForm($order);
        return view('trips.edit', compact('order', 'form', 'states', 'selectedstate'));
    }

    public function update(Order $order)
    {
        $this->canIEdit($order, 'project');

        $form = new TravelProjectForm($order);

        if ($form->process()) {
            return redirect()->route('next', $order->id);
        }

        return redirect()->back();
    }
}
