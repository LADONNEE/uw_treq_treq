<?php
namespace App\Trackers;

class LoggableListChanges implements Loggable
{
    private $itemLabel;
    private $changes = [];

    public function __construct(string $itemLabel = null)
    {
        $this->itemLabel = ($itemLabel) ? "updated {$itemLabel}: " : '';
    }

    public function isEmpty(): bool
    {
        return count($this->changes) === 0;
    }

    public function getMessage(): string
    {
        return $this->itemLabel . implode(', ', $this->changes);
    }

    public function deleted($itemName)
    {
        $this->changes[] = "deleted {$itemName}";
    }

    public function added($itemName, $itemState)
    {
        $this->changes[] = "added {$itemName} ($itemState)";
    }

    public function updated($itemName, $itemState)
    {
        $this->changes[] = "updated {$itemName} ($itemState)";
    }
}
