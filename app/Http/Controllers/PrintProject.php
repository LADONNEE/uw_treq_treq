<?php

namespace App\Http\Controllers;

use App\Models\Project;

class PrintProject
{
    public function __invoke(Project $project)
    {
        if (count($project->orders) === 0) {
            abort(404, 'Project has 0 orders');
        }
        $order = $project->orders[0];
        return view('print.show', compact('order', 'project'));
    }
}
