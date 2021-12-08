<?php
namespace App\Models;

use App\Contracts\HasNames;

/**
 * @property integer  $person_id
 * @property string   $uwnetid
 * @property integer  $studentno
 * @property integer  $employeeid
 * @property string   $firstname
 * @property string   $lastname
 * @property string   $email
 */
class Person extends ReadOnlyModel implements HasNames
{
    protected $table = 'shared.uw_persons';
    protected $fillable = [
        'uwnetid',
        'studentno',
        'employeeid',
        'firstname',
        'lastname',
        'email',
    ];
    protected $primaryKey = 'person_id';

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
        if ($this->uwnetid) {
            return $this->uwnetid;
        }
        return "person_id:{$this->person_id}";
    }
}
