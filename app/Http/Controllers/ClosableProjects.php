<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Reports\ClosableProjectsReport;

class ClosableProjects extends Controller
{
    public function __invoke()
    {
        $title = 'Closable projects';
        $report = new ClosableProjectsReport();        
        if (wantsCsv()) {
            $reportdata = $report->load();
            return response()->view('closable-projects.csv', compact('reportdata'));
        }
    return view('closable-projects.index', compact('report'));

    }      
    
    
}




