<?php
namespace App\Trackers;

use App\Models\OrderLog;
use App\Models\Perdiem;
use App\Trackers\Snapshots\PerdiemSnapshot;
use App\Trackers\Snapshots\Snapshot;

class LoggedPerdiem extends LoggedUpdate
{
    private $perdiem;
    private $patch;
    private $actor_id;

    public $shouldLog = true;

    public function __construct(Perdiem $perdiem, array $patch, $actor_id)
    {
        $this->perdiem = $perdiem;
        $this->patch = $patch;
        $this->actor_id = $actor_id;
    }

    public function execute()
    {
        $this->update();
    }

    protected function applyPatch()
    {
        $this->perdiem->fill($this->patch);
        $this->perdiem->save();
    }

    protected function newSnapshot(): ?Snapshot
    {
        return new PerdiemSnapshot($this->perdiem);
    }

    protected function writeLog($message)
    {
        $log = new OrderLog([
            'order_id' => $this->perdiem->order_id,
            'actor_id' => $this->actor_id,
            'message' => $message,
        ]);
        $log->save();
    }
}
