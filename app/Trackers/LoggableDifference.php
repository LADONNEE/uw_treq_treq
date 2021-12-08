<?php
namespace App\Trackers;

class LoggableDifference implements Loggable
{
    private $itemLabel = null;
    private $diffs = [];

    public function __construct(string $itemLabel = null)
    {
        $this->itemLabel = ($itemLabel) ? "{$itemLabel} " : null;
    }

    public function addDifference($label, $newValue)
    {
        if ($newValue === '' || $newValue === null) {
            $newValue = '(empty)';
        }
        $this->diffs[$label] = $newValue;
    }

    public function isEmpty(): bool
    {
        return count($this->diffs) === 0;
    }

    public function getMessage(): string
    {
        $out = [];
        foreach ($this->diffs as $label => $value) {
            $out[] = "{$label} = {$value}";
        }
        return 'set ' . $this->itemLabel . implode(', ', $out);
    }
}
