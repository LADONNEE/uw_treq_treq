<?php
namespace App\Trackers\Snapshots;

use App\Trackers\Loggable;
use App\Trackers\LoggableListChanges;

abstract class SnapshotList extends Snapshot
{
    public function diff(Snapshot $afterSnapshot): Loggable
    {
        $diff = new LoggableListChanges($this->getItemLabel());

        foreach ($this->state as $itemName => $beforeState) {
            if ($afterSnapshot->has($itemName)) {
                $after = $afterSnapshot->get($itemName);
                if ($beforeState->isChanged($after)) {
                    $diff->updated($itemName, $after->value);
                }
            } else {
                $diff->deleted($itemName);
            }
        }

        foreach ($afterSnapshot->all() as $itemName => $after) {
            if (!$this->has($itemName)) {
                $diff->added($itemName, $after->value);
            }
        }
        return $diff;
    }

    protected function addItem($name, $state)
    {
        $this->state[$name] = Snap::text($state);
    }
}
