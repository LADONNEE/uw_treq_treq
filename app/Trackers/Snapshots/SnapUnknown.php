<?php
namespace App\Trackers\Snapshots;

class SnapUnknown extends SnapField
{
    public function __construct()
    {
        parent::__construct(self::EMPTY);
    }
}
