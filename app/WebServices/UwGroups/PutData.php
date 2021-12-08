<?php

namespace App\WebServices\UwGroups;

class PutData
{
    private $fields = [
        'id',
        'displayName',
        'description',
        'contact',
        'authnfactor',
        'classification',
        'dependsOn',
    ];
    private $lists = [
        'admins',
        'updaters',
        'creators',
        'readers',
        'optins',
        'optouts',
    ];

    public function getData(UwGroup $group)
    {
        $out = new \stdClass();

        foreach ($this->fields as $field) {
            if (isset($group->{$field})) {
                $out->{$field} = $group->{$field};
            }
        }

        foreach ($this->lists as $list) {
            if (isset($group->{$list}) && $group->{$list}->count() > 0) {
                $out->{$list} = $group->{$list}->all();
            }
        }

        return $out;
    }
}
