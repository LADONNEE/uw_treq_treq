<?php
namespace App\Http\Controllers;

use App\Forms\ProjectForm;
use App\Forms\TravelProjectForm;
use App\Models\Order;
use App\Models\Project;
use App\Models\State;
use App\Reports\PersonOpenTripsReport;
use App\Workflows\OrderTypes;


class ProjectController extends Controller
{
    public function show(Project $project, $adding = false)
    {
        $states = State::orderBy('id')->get();
        $adding = (bool) $adding;
        $types = (new OrderTypes())->types;
        return view('projects.show', compact('project', 'types', 'adding', 'states'));
    }

    public function create($type)
    {
        $states = State::orderBy('id')->get();
        $selectedstate = '';

        $projects = $this->getUsersOpenTrips($type, request('new'));
        if ($projects && count($projects) > 0) {
            return view('trips.open-trips', compact('projects', 'states'));
        }

        $order = new Order(['type' => $type]);

        if ($order->isTravel()) {
            $form = new TravelProjectForm($order);
            return view('trips.create', compact('order', 'form', 'states', 'selectedstate'));
        }

        $form = new ProjectForm($order);
        return view('projects.create', compact('order', 'form', 'states'));
    }

    public function store($type)
    {
        $order = new Order(['type' => $type]);
        $form = ($order->isTravel()) ? new TravelProjectForm($order) : new ProjectForm($order);

        if ($form->process()) {
            return redirect()->route('next', $order->id);
        }

        return redirect()->back();
    }

    public function edit(Order $order)
    {
        $this->canIEdit($order, 'project');
        $states = State::orderBy('id')->get();

        $form = new ProjectForm($order);
        return view('projects.edit', compact('order', 'form', 'states'));
    }

    public function update(Order $order)
    {
        $this->canIEdit($order, 'project');

        $form = new ProjectForm($order);

        if ($form->process()) {
            return redirect()->route('next', $order->id);
        }

        return redirect()->back();
    }

    private function getUsersOpenTrips($type, $confirmedNew)
    {
        if ($confirmedNew || $type !== OrderTypes::TRAVEL_REIMBURSEMENT) {
            return false;
        }

        if(hasRole('treq:fiscal')){
            $report = new PersonOpenTripsReport('%');
        }
        else {
            $report = new PersonOpenTripsReport(user()->person_id);
        }
        
        return $report->projects;
    }
}
