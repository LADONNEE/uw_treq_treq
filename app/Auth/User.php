<?php
namespace App\Auth;

use App\Contracts\HasNames;
use App\Models\Auth;
use App\Models\Person;
use Utilws\Aclkit\Contracts\UserWithRoles;

class User implements HasNames, UserWithRoles
{
    public $uwnetid;
    public $person_id;
    public $firstname;
    public $lastname;

    // these properties are populated by UsersReport for user index page
    public $folderUrl;
    public $folderName;

    protected $loaded = false;
    protected $roles;

    public function __construct($uwnetid, $initData = null)
    {
        $this->uwnetid = $uwnetid;
        if ($initData) {
            $this->init($initData);
        } else {
            $this->load();
        }
    }

    /**
     * Runtime append for bulk loading Users with roles
     * This does not persist the user role
     * @param string $role
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    public function getFirst()
    {
        return $this->firstname;
    }

    public function getLast()
    {
        return $this->lastname;
    }

    public function getIdentifier()
    {
        return $this->uwnetid;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function hasRole($role)
    {
        return in_array($role, $this->getRoles());
    }

    public function init($data)
    {
        if (is_array($data)) {
            $this->person_id = $data['person_id'] ?? null;
            $this->firstname = $data['firstname'] ?? null;
            $this->lastname = $data['lastname'] ?? null;
            $this->roles = $data['roles'] ?? [];
            $this->folderName = $data['folder_name'] ?? null;
            $this->folderUrl = $data['folder_url'] ?? null;
        } else {
            $this->person_id = $data->person_id ?? null;
            $this->firstname = $data->firstname ?? null;
            $this->lastname = $data->lastname ?? null;
            $this->roles = $data->roles ?? [];
            $this->folderName = $data->folder_name ?? null;
            $this->folderUrl = $data->folder_url ?? null;
        }
    }

    protected function load()
    {
        $person = Person::where('uwnetid', $this->uwnetid)->first();
        if ($person) {
            $this->person_id = $person->person_id;
            $this->firstname = $person->firstname;
            $this->lastname = $person->lastname;
        }
        $this->roles = Auth::where('uwnetid', $this->uwnetid)
            ->pluck('role')
            ->all();
    }
}
