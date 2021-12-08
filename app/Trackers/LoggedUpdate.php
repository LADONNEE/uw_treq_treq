<?php
namespace App\Trackers;

use App\Trackers\Snapshots\Snapshot;

abstract class LoggedUpdate
{
    public $shouldLog = true;

    abstract public function execute();

    abstract protected function applyPatch();

    abstract protected function writeLog($message);

    protected function newSnapshot(): ?Snapshot
    {
        return null;
    }

    protected function update()
    {
        $before = ($this->shouldLog) ? $this->newSnapshot() : null;

        $this->applyPatch();

        if (!$before) {
            return;
        }

        $diff = $before->diff($this->newSnapshot());

        if ($diff->isEmpty()) {
            return;
        }

        $this->writeLog($diff->getMessage());
    }
}
