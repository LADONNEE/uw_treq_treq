<?php
namespace App\Trackers\Snapshots;

class SnapField
{
    const EMPTY = '';
    public $value;

    public function __construct($value)
    {
        if ($this->isEmpty($value)) {
            $this->value = self::EMPTY;
        } else {
            $this->value = $this->normalizeValue($value);
        }
    }

    public function isChanged(SnapField $after)
    {
        return $this->value !== $after->value;
    }

    public function format()
    {
        return $this->value;
    }

    protected function normalizeValue($value)
    {
        return (string) $value;
    }

    protected function isEmpty($value)
    {
        return $value === null || $value === '';
    }
}
