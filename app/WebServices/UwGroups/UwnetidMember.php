<?php

namespace App\WebServices\UwGroups;

class UwnetidMember extends Member
{
    public function __construct($uwnetid)
    {
        parent::__construct($uwnetid, 'uwnetid');
    }
}
