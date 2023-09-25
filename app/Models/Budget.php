<?php
namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer $id
 * @property integer $order_id
 * @property string $budgetno
 * @property string $pca_code
 * @property integer $project_code_id
 * @property string $opt_code
 * @property string $name
 * @property string $split_type
 * @property float $split
 * @property string $wd_costcenter
 * @property string $wd_program
 * @property string $wd_standalonegrant
 * @property string $wd_grant
 * @property string $wd_assignee
 * @property string $wd_gift
 * @property string $wd_fund
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * ----------   Relationships   ----------
 * @property Order $order
 */
class Budget extends Model
{
    public static $splitTypes = [
        'A' => 'Dollar Amount',
        'P' => 'Percentage',
        'R' => 'Remainder',
    ];

    protected $table = 'budgets';
    protected $fillable = [
        'order_id',
        'budgetno',
        'pca_code',
        'project_code_id',
        'opt_code',
        'name',
        'split_type',
        'split',
        'wd_costcenter',
        'wd_program',
        'wd_standalonegrant',
        'wd_grant',
        'wd_assignee',
        'wd_gift',
        'wd_fund',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function splitDescription()
    {
        if ($this->split_type === 'R') {
            return '*';
        }
        if (!$this->split) {
            return '';
        }
        if ($this->split_type === 'A') {
            return '$' . number_format($this->split, 2);
        }
        if ($this->split_type === 'P') {
            return (int)($this->split * 10000) / 10000.0 . '%';
        }
        return $this->split . ' ' . $this->split_type;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
