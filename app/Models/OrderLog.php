<?php
namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property integer  $actor_id
 * @property integer  $project_id
 * @property integer  $task_id
 * @property string   $message
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 * @property Person $actor
 */
class OrderLog extends Model
{
    protected $table = 'order_logs';
    protected $fillable = [
        'order_id',
        'actor_id',
        'project_id',
        'task_id',
        'message',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function actor()
    {
        return $this->belongsTo(Person::class, 'actor_id', 'person_id');
    }
}
