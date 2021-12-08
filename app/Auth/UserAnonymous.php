<?php
namespace App\Auth;

class UserAnonymous extends User
{
    public function __construct()
    {
        parent::__construct('(nologin)');
    }

    protected function lazyLoad()
    {
        if ($this->loaded) {
            return;
        }
        $this->person_id = 0;
        $this->firstname = null;
        $this->lastname = 'Not Logged In';
        $this->roles = [];
        $this->loaded = true;
    }
}
