<?php
namespace App\Trackers\Snapshots;

class SnapPerson extends SnapField
{
    public static $personFormatter = 'eFirstLast';

    protected function normalizeValue($value)
    {
        if ($value) {
            return (int) $value;
        }

        return self::EMPTY;
    }

    public function format()
    {
        if ($this->value) {
            return call_user_func(self::$personFormatter, $this->value);
        }

        return $this->value;
    }
}
