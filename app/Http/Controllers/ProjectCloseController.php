<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Project;

class ProjectCloseController extends Controller
{
    public function order(Order $order)
    {
        $this->close($order);

        return redirect()->route('order', $order->id);
    }

    public function project(Project $project)
    {
        // grab most recent order for log context
        $order = Order::where('project_id', $project->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$order) {
            abort(404, "No orders found for project {$project->id}");
        }

        $this->close($order);

        return redirect()->route('project', $project->id);
    }

    private function close(Order $order)
    {
        if (!$order->project->canClose()) {
            abort(403, "Project {$order->project_id} can not be closed");
        }

        $order->project->close(user());

        $log = new OrderLog([
            'order_id' => $order->id,
            'actor_id' => user()->person_id,
            'project_id' => $order->project_id,
            'message' => 'closed project',
        ]);
        $log->save();
    }
}
