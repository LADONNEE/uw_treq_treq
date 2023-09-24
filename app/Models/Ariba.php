<?php
namespace App\Models;

use App\Auth\User;
use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property string   $ref
 * @property string   $description
 * @property integer  $created_by
 * @property integer  $updated_by
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 * @property Order $order
 * @property Person $person
 */
class Ariba extends Model
{
    protected $table = 'ariba';
    protected $fillable = [
        'order_id',
        'ref',
        'description',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'created_by', 'person_id');
    }
}
