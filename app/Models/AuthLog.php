<?php
namespace App\Models;


/**
 * @property integer         $id
 * @property integer         $uwnetid
 * @property integer         $actor_id
 * @property string          $message
 * @property \Carbon\Carbon  $created_at
 * @property \Carbon\Carbon  $updated_at
 * ----- Relationships ------------------------
 * @property Person $actor
 */
class AuthLog extends Model
{
    protected $table = 'auth_logs';
    protected $fillable = [
        'uwnetid',
        'actor_id',
        'message',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function actor()
    {
        return $this->belongsTo(Person::class, 'actor_id', 'person_id');
    }

}
