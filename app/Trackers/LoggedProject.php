<?php
namespace App\Trackers;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Project;
use App\Trackers\Snapshots\ProjectSnapshot;
use App\Trackers\Snapshots\Snapshot;

class LoggedProject extends LoggedUpdate
{
    private $order;
    private $project;
    private $patch;
    private $actor_id;

    public $shouldLog = true;

    public function __construct(Order $order, Project $project, array $patch, $actor_id)
    {
        $this->order = $order;
        $this->project = $project;
        $this->patch = $patch;
        $this->actor_id = $actor_id;
    }

    public function execute()
    {
        if ($this->project->exists) {
            $this->update();
        } else {
            $this->applyPatch();
            $this->writeLog('started new project');
        }
    }

    protected function applyPatch()
    {
        $this->project->fill($this->patch);
        $this->project->person_id = $this->project->person_id ?? $this->actor_id;
        $this->project->save();

        $this->order->fill([
            'project_id' => $this->project->id,
            'stage' => $this->order->stage ?? Order::STAGE_CREATING,
            'submitted_by' => $this->order->submitted_by ?? $this->actor_id,
        ]);
        $this->order->save();
    }

    protected function newSnapshot(): ?Snapshot
    {
        return new ProjectSnapshot($this->project);
    }

    protected function writeLog($message)
    {
        $log = new OrderLog([
            'order_id' => $this->order->id,
            'actor_id' => $this->actor_id,
            'project_id' => $this->project->id,
            'message' => $message,
        ]);
        $log->save();
    }
}
