<?php
namespace App\Models;

use App\Auth\User;
use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property string   $section
 * @property string   $note
 * @property integer  $created_by
 * @property integer  $updated_by
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 * @property Order $order
 * @property Person $person
 */
class Note extends Model
{
    const DEFAULT_SECTION = 'order';

    protected $table = 'notes';
    protected $fillable = [
        'order_id',
        'section',
        'note',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $sections = [
        self::DEFAULT_SECTION,
        'budget',
        'items',
    ];

    public function editedBy($user)
    {
        if ($user instanceof User) {
            $user = $user->person_id;
        }
        if (!$this->created_by) {
            $this->created_by = (int) $user;
        } else {
            $this->updated_by = (int) $user;
        }
    }

    public function editedMessage()
    {
        if ($this->wasEdited()) {
            return sprintf('Edited by %s, %s', eFirstLast($this->updated_by), eDate($this->updated_at));
        }
        return '';
    }

    public function userCanEdit(User $user)
    {
        return $user->person_id === $this->created_by || hasRole('edit-notes', $user);
    }

    public function wasEdited()
    {
        return (bool) $this->updated_by;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'created_by', 'person_id');
    }

    protected function preSave()
    {
        if (!$this->section) {
            $this->section = self::DEFAULT_SECTION;
        }
        return parent::preSave();
    }
}
