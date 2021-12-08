<?php

namespace App\WebServices\UwGroups;

class Member
{
    public $type;
    public $id;

    public function __construct($id, $type)
    {
        $this->id = $id;
        $this->type = $type;
    }
}
