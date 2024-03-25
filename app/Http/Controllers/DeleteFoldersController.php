<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Project;
use App\Reports\DeleteFoldersReport;

class DeleteFoldersController extends Controller
{
    public function index()
    {
        
        $report = new DeleteFoldersReport();
        
        if (wantsCsv()) {
            $reportdata = $report->load();
            return response()->view('delete-folders.csv', compact('reportdata'));
        }
        return view('delete-folders.index', compact('report'));
    }

    public function edit(Project $project)
    {
        return view('delete-folders.edit', compact('project'));
    }

    public function update(Project $project)
    {
        // grab most recent order for log context
        $order = Order::where('project_id', $project->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$order) {
            abort(404, "No orders found for project {$project->id}");
        }

        $this->markFolderDeleted($order);

        $this->flash('Marked folder deleted for ' . projectNumber($project));

        return redirect()->route('delete-folders');
    }

    private function markFolderDeleted(Order $order)
    {
        if (!$order->project->canClose()) {
            abort(403, "Project {$order->project_id} can not be closed");
        }

        $order->project->folderDeleted(user());

        $log = new OrderLog([
            'order_id' => $order->id,
            'actor_id' => user()->person_id,
            'project_id' => $order->project_id,
            'message' => 'deleted OneDrive folder',
        ]);
        $log->save();
    }
}
