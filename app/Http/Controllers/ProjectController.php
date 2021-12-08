<?php
namespace App\Http\Controllers;

use App\Forms\ProjectForm;
use App\Forms\TravelProjectForm;
use App\Models\Order;
use App\Models\Project;
use App\Reports\PersonOpenTripsReport;
use App\Workflows\OrderTypes;

class ProjectController extends Controller
{
    public function show(Project $project, $adding = false)
    {
        $adding = (bool) $adding;
        $types = (new OrderTypes())->types;
        return view('projects.show', compact('project', 'types', 'adding'));
    }

    public function create($type)
    {
        $projects = $this->getUsersOpenTrips($type, request('new'));
        if ($projects && count($projects) > 0) {
            return view('trips.open-trips', compact('projects'));
        }

        $order = new Order(['type' => $type]);

        if ($order->isTravel()) {
            $form = new TravelProjectForm($order);
            return view('trips.create', compact('order', 'form'));
        }

        $form = new ProjectForm($order);
        return view('projects.create', compact('order', 'form'));
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

        $form = new ProjectForm($order);
        return view('projects.edit', compact('order', 'form'));
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

        $report = new PersonOpenTripsReport(user()->person_id);
        return $report->projects;
    }
}
