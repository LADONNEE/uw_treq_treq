<?php

namespace App\Http\Controllers;

use App\Reports\ClosableProjectsReport;

class ClosableProjects extends Controller
{
    public function __invoke()
    {
        $report = new ClosableProjectsReport();
        return view('closable-projects.index', compact('report'));
    }
}
