<?php
namespace App\Trackers\Snapshots;

use Carbon\Carbon;

class SnapYesNo extends SnapField
{
    protected function normalizeValue($value)
    {
        if ($value === 'N') {
            return 'No';
        }
        return ($value) ? 'Yes' : 'No';
    }
}
