<?php
namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer  $id
 * @property string   $name
 * @property string   $task_type
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 */
class Stage extends Model
{
    protected $table = 'stages';
    protected $fillable = [
        'name',
        'task_type',
    ];
    protected $casts = [
        'created_at',
        'updated_at',
    ];

}
