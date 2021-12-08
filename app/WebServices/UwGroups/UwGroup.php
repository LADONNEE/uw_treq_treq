<?php

namespace App\WebServices\UwGroups;

use Carbon\Carbon;

class UwGroup
{
    // Fields submitted to service for create/update
    public $regid;  // "a1681c3fcba3f54f759e6c9432004381",
    public $id;  // "u_fox_browser6",
    public $displayName;  // "Fox's test group",
    public $description;  // "This is a general purpose group for testing various Group Service functionality.",
    public $contact;  // "fox",
    public $authnfactor = 0;  // 0,
    public $classification = 'u';  // "u",
    public $dependsOn;  // "uw_employee",

    // Read-only fields
    public $created;
    public $lastModified;
    public $lastMemberModified;
    public $authnFactor;
    public $gid;

    public $admins;
    public $updaters;
    public $creators;
    public $readers;
    public $optins;
    public $optouts;
    public $members;

    private $scalarProperties = [
        'regid',
        'id',
        'displayName',
        'description',
        'contact',
        'authnfactor',
        'classification',
        'dependsOn',
        'authnFactor',
        'gid',
    ];

    private $dates = [
        'created',
        'lastModified',
        'lastMemberModified',
    ];

    private $memberLists = [
        'admins',
        'updaters',
        'creators',
        'readers',
        'optins',
        'optouts',
    ];

    public function __construct($id, $displayName = null, $contact = null)
    {
        $this->id = $id;
        $this->displayName = $displayName;
        $this->contact = $contact;

        $this->admins = new MemberList();
        $this->updaters = new MemberList();
        $this->creators = new MemberList();
        $this->readers = new MemberList();
        $this->optins = new MemberList();
        $this->optouts = new MemberList();
        $this->members = new MemberList();
    }

    public function fillJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }
        $data = $json->data;

        foreach ($this->scalarProperties as $property) {
            $this->{$property} = $data->{$property} ?? null;
        }

        foreach ($this->dates as $property) {
            if (isset($data->{$property}) && $data->{$property}) {
                $this->{$property} = Carbon::createFromTimestampMs($data->{$property});
            } else {
                $this->{$property} = null;
            }
        }

        foreach ($this->memberLists as $list) {
            $this->{$list} = new MemberList();
            echo " . processing MemberList {$list} ";
            if (isset($data->{$list}) && is_array($data->{$list})) {
                echo count($data->{$list}), " items \n";
                foreach ($data->{$list} as $dm) {
                    $this->{$list}->addMember(new Member($dm->id, $dm->type));
                }
            } else {
                echo " NOT FOUND in data\n";
            }
        }
    }

    public function fillMembersJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }
        $data = $json->data;

        $this->members = new MemberList();

        foreach ($data as $dm) {
            $this->members->addMember(new Member($dm->id, $dm->type));
        }
    }

    public function getWebServiceRequest()
    {
        return (new PutData())->getData($this);
    }
}
