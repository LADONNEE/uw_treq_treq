<?php
namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer  $id
 * @property string   $uwnetid
 * @property string   $role
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 */
class Auth extends Model
{
    protected $table = 'auth';
    protected $fillable = [
        'uwnetid',
        'role',
    ];
    protected $casts = [
        'created_at',
        'updated_at',
    ];

}
