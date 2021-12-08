<?php
namespace App\Trackers\Snapshots;

use App\Models\Perdiem;

class PerdiemSnapshot extends Snapshot
{
    public function __construct(Perdiem $perdiem)
    {
        $this->state = [
            'nights' => Snap::text($perdiem->nights),
            'lodging per diem' => Snap::text($perdiem->lodging_pd),
            'lodging total' => Snap::text($perdiem->lodging),
            'days' => Snap::text($perdiem->days),
            'meals per diem' => Snap::text($perdiem->meals_pd),
            'meals total' => Snap::text($perdiem->meals),
        ];
    }

    public function getItemLabel(): string
    {
        return 'per diem';
    }
}
