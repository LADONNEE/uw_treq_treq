<?php
namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property integer  $nights
 * @property integer  $lodging_pd
 * @property float    $lodging
 * @property integer  $days
 * @property integer  $meals_pd
 * @property integer  $meals
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 * @property Order $order
 */
class Perdiem extends Model
{
    protected $table = 'perdiems';
    protected $fillable = [
        'order_id',
        'nights',
        'lodging_pd',
        'lodging',
        'days',
        'meals_pd',
        'meals',
    ];
    protected $casts = [
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
