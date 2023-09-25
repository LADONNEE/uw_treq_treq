<?php
namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property string   $item
 * @property string   $answer
 * @property string   $note
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 */
class TripNote extends Model
{
    protected $table = 'trip_notes';
    protected $fillable = [
        'order_id',
        'item',
        'answer',
        'note',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
