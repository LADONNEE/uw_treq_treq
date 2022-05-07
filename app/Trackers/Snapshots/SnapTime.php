<?php
namespace App\Trackers\Snapshots;

use Carbon\Carbon;

class SnapTime extends SnapField
{
    protected function normalizeValue($value)
    {
        if ($value instanceof Carbon) {
            return $value->format('g:i A');
        }

        return parent::normalizeValue($value);
    }
}
