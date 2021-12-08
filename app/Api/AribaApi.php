<?php
namespace App\Api;

class AribaApi
{
    public $items;

    public function __construct($aribas)
    {
        $this->items = [];
        foreach ($aribas as $ariba) {
            $this->items[] = new AribaApiItem($ariba);
        }
    }

    public function toJson()
    {
        return json_encode($this->items);
    }
}
