<?php
namespace App\Api;

use App\Models\Ariba;

class AribaApiItem
{
    public $id;
    public $ref;
    public $description;
    public $creator;
    public $createdAt;

    public function __construct(Ariba $ariba)
    {
        $this->id = $ariba->id;
        $this->ref = $ariba->ref;
        $this->description = $ariba->description;
        $this->creator = eFirstLast($ariba->created_by);
        $this->createdAt = eDate($ariba->created_at);
    }
}
