<?php

namespace App\Trackers;

use App\Models\Ariba;
use App\Models\OrderLog;
use App\Trackers\Snapshots\AribaSnapshot;
use App\Trackers\Snapshots\Snapshot;

class LoggedAriba extends LoggedUpdate
{
    private $ariba;
    private $actor_id;
    private $patch;

    public $shouldLog = true;

    public function __construct(Ariba $ariba, $actor_id, $patch = null)
    {
        $this->ariba = $ariba;
        $this->actor_id = $actor_id;
        $this->patch = $patch;
    }

    public function execute()
    {
        if ($this->ariba->exists) {
            $this->update();
        } else {
            $this->applyPatch();
            $this->writeLog('added Ariba ref ' . $this->ariba->ref);
        }
    }

    public function delete()
    {
        $this->ariba->delete();
        $this->writeLog('deleted Ariba ref ' . $this->ariba->ref);
    }

    protected function applyPatch()
    {
        $this->ariba->fill($this->patch);
        $this->ariba->save();
    }

    protected function newSnapshot(): ?Snapshot
    {
        return new AribaSnapshot($this->ariba);
    }

    protected function writeLog($message)
    {
        $log = new OrderLog([
            'order_id' => $this->ariba->order_id,
            'actor_id' => $this->actor_id,
            'message' => $message,
        ]);
        $log->save();
    }
}
