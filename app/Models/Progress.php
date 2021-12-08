<?php
namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property integer  $project_id
 * @property string   $step
 * @property integer  $completed_by
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 * @property Order $order
 */
class Progress extends Model
{
    protected $table = 'progress';
    protected $fillable = [
        'order_id',
        'project_id',
        'step',
        'completed_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
