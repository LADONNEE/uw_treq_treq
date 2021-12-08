<?php
namespace App\Trackers\Snapshots;

use App\Trackers\LoggableDifference;
use App\Trackers\Loggable;

abstract class Snapshot
{
    /**
     * Implementations are responsible for populating state as an associative array
     * of SnapField objects. The array should have string $label array keys that can
     * be used to describe the given field in a log message.
     * @var SnapField[]
     */
    protected $state = [];

    abstract public function getItemLabel(): string;

    public function get($label): SnapField
    {
        return $this->state[$label] ?? new SnapUnknown();
    }

    public function all()
    {
        return $this->state;
    }

    public function has($label): bool
    {
        return isset($this->state[$label]);
    }

    public function diff(self $afterSnapshot): Loggable
    {
        $diff = new LoggableDifference($this->getItemLabel());

        foreach ($this->state as $label => $before) {
            $after = $afterSnapshot->get($label);
            if ($before->isChanged($after)) {
                $diff->addDifference($label, $after->format());
            }
        }

        return $diff;
    }
}
