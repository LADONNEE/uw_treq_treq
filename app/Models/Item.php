<?php
namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property string   $name
 * @property string   $url
 * @property integer  $qty
 * @property float    $amount
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 * @property Order $order
 */
class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'order_id',
        'name',
        'url',
        'qty',
        'amount',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function nameQtyAmount()
    {
        if ($this->qty == 1) {
            return $this->name;
        }

        return "{$this->name} ({$this->qty} x {$this->amount})";
    }

    public function lineTotal()
    {
        if (!$this->qty || !$this->amount) {
            return '0.00';
        }
        if ($this->qty == 1) {
            return $this->amount;
        }

        return number_format($this->qty * $this->amount, 2);
    }

    public function setAmountAttribute($value)
    {
        $negative = (strpos($value, '-') === 0) ? -1 : 1;
        $value = preg_replace('/[^0-9\.]/', '', $value);
        if ($value) {
            $this->attributes['amount'] = $negative * round($value, 2);
        } else {
            $this->attributes['amount'] = null;
        }
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    protected function preSave()
    {
        if (!$this->qty) {
            $this->qty = 1;
        }
    }
}
