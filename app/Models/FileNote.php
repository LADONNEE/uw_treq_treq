<?php
namespace App\Models;

use App\Auth\User;
use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $project_id
 * @property string   $note
 * @property integer  $created_by
 * @property integer  $updated_by
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 */
class FileNote extends Model
{
    protected $table = 'file_notes';
    protected $fillable = [
        'project_id',
        'note',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'created_at',
        'updated_at',
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
}
