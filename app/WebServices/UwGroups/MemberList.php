<?php

namespace App\WebServices\UwGroups;

class MemberList implements \Iterator
{
    private $pointer = 0;

    /**
     * @var Member[]
     */
    public $members = [];

    public function addMember(Member $member)
    {
        $this->members[] = $member;
    }

    public function all()
    {
        return $this->members;
    }

    public function count()
    {
        return count($this->members);
    }

    public function rewind()
    {
        $this->pointer = 0;
    }

    public function current()
    {
        return $this->members[$this->pointer];
    }

    public function key()
    {
        return $this->pointer;
    }

    public function next()
    {
        ++$this->pointer;
    }

    public function valid()
    {
        return $this->pointer < count($this->members);
    }
}
