<?php

namespace App\WebServices\UwGroups;

class DnsMember extends Member
{
    public function __construct($uwnetid)
    {
        parent::__construct($uwnetid, 'dns');
    }
}
