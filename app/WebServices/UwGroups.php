<?php

namespace App\WebServices;

use App\WebServices\UwGroups\DnsMember;
use App\WebServices\UwGroups\UwGroup;
use App\WebServices\UwGroups\UwGroupsService;
use App\WebServices\UwGroups\UwnetidMember;
use Psr\Http\Message\ResponseInterface;

class UwGroups
{
    public static function get($group = 'u_coetechn_techstaff')
    {
        $ws = new UwGroupsService();
        $res = $ws->lookup($group);

        $group = new UwGroup($group);
        $group->fillJson((string) $res->getBody());

        return $group;
    }

    public static function members($group = 'u_coetechn_techstaff')
    {
        $ws = new UwGroupsService();
        $res = $ws->members($group);

        $group = new UwGroup($group);
        $group->fillMembersJson((string) $res->getBody());

        return $group;
    }

    public static function setMembers($group = 'u_hanisko_treq_child')
    {
        $group = new UwGroup($group);
        $group->members->addMember(new UwnetidMember('ymichea'));
        $group->members->addMember(new UwnetidMember('cadavis1'));
        $group->members->addMember(new UwnetidMember('pkeyes'));
        $group->members->addMember(new UwnetidMember('bossim1'));

        $ws = new UwGroupsService();
        $res = $ws->setMembers($group);

        self::debug($res);
    }

    public static function create()
    {
        $group = new UwGroup('u_hanisko_treq_child2', 'TREQ Child Second Group Test', 'hanisko');
        $group->admins->addMember(new UwnetidMember('hanisko'));
        $group->admins->addMember(new DnsMember('groups-client.educ.uw.edu'));

        $ws = new UwGroupsService();
        $res = $ws->create($group->id, $group->getWebServiceRequest());

        self::debug($res);
    }

    private static function debug(ResponseInterface $res)
    {
        echo '| STATUS-CODE: ', $res->getStatusCode(), "\n\n";
        echo '| CONTENT-TYPE: ', $res->getHeader('content-type')[0], "\n\n";
        echo $res->getBody(), "\n\n";
    }
}
