<?php
namespace App\Trackers\Snapshots;

use App\Models\Ariba;

class AribaSnapshot extends Snapshot
{
    public function __construct(Ariba $ariba)
    {
        $this->state = [
            'ref' => Snap::text($ariba->ref),
            'description' => Snap::text($ariba->description),
        ];
    }

    public function getItemLabel(): string
    {
        return "ariba {$this->state['ref']->value}";
    }
}
