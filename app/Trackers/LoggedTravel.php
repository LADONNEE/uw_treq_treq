<?php
namespace App\Trackers;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Project;
use App\Models\Trip;
use App\Trackers\Snapshots\Snapshot;
use App\Trackers\Snapshots\TravelSnapshot;

class LoggedTravel extends LoggedUpdate
{
    private $order;
    private $project;
    private $purpose;
    private $trip;
    private $tripPatch;
    private $actor_id;

    public $shouldLog = true;

    public function __construct(Order $order, Project $project, Trip $trip, $purpose, array $tripPatch, $actor_id)
    {
        $this->order = $order;
        $this->project = $project;
        $this->trip = $trip;
        $this->purpose = $purpose;
        $this->tripPatch = $tripPatch;
        $this->actor_id = $actor_id;
    }

    public function execute()
    {
        if ($this->project->exists) {
            $this->update();
        } else {
            $this->applyPatch();
            $this->writeLog('started new travel project');
        }
    }

    protected function applyPatch()
    {
        $this->trip->fill($this->tripPatch);

        $this->project->purpose = $this->purpose;
        $this->project->relevance = $this->tripPatch['relevance'] ?? '';
        $this->project->arrangement = $this->tripPatch['arrangement'] ?? '';
        $this->project->person_id = $this->project->person_id ?? $this->actor_id;
        $this->project->titleFromTrip($this->trip);
        $this->project->is_travel = true;
        $this->project->save();

        $this->trip->project_id = $this->project->id;
        $this->trip->save();

        $this->order->fill([
            'project_id' => $this->project->id,
            'stage' => $this->order->stage ?? Order::STAGE_CREATING,
            'submitted_by' => $this->order->submitted_by ?? $this->actor_id,
        ]);
        $this->order->save();
    }

    protected function newSnapshot(): ?Snapshot
    {
        return new TravelSnapshot($this->project, $this->trip);
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
