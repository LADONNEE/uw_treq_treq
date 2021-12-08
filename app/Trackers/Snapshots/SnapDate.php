<?php
namespace App\Trackers\Snapshots;

use Carbon\Carbon;

class SnapDate extends SnapField
{
    protected function normalizeValue($value)
    {
        if ($value instanceof Carbon) {
            return $value->format('n/j/Y');
        }

        return parent::normalizeValue($value);
    }
}
