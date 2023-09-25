<?php
namespace App\Models;

use App\Auth\User;
use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property string   $type
 * @property integer  $sequence
 * @property boolean  $is_approval
 * @property string   $budgetno
 * @property string   $name
 * @property string   $description
 * @property integer  $created_by
 * @property integer  $assigned_to
 * @property Carbon   $notified_at
 * @property string   $response
 * @property string   $message
 * @property integer  $completed_by
 * @property Carbon   $completed_at
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 * @property Order $order
 * @property Person $assignee
 * @property Person $completer
 * @property Person $creator
 */
class Task extends Model
{
    const TYPE_APPROVAL = 'approval';
    const TYPE_ARIBA = 'ariba';
    const TYPE_BUDGET = 'budget';
    const TYPE_DEPARTMENT = 'department';
    const TYPE_ORDER = 'order';
    const TYPE_RESUBMIT = 'resubmit';
    const TYPE_TASK = 'task';

    const RESPONSE_APPROVED = 'Approved';
    const RESPONSE_SENTBACK = 'Sent Back';
    const RESPONSE_COMPLETED = 'Completed';

    protected $table = 'tasks';
    protected $fillable = [
        'order_id',
        'type',
        'name',
        'sequence',
        'is_approval',
        'budgetno',
        'description',
        'created_by',
        'assigned_to',
        'notified_at',
        'response',
        'message',
        'completed_by',
        'completed_at',
    ];
    protected $casts = [
        'notified_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function canComplete(User $user)
    {
        if ($this->isComplete()) {
            return false;
        }
        return $user->person_id === $this->assigned_to || hasRole('act-on-behalf', $user);
    }

    public function canDelete(User $user)
    {
        if ($this->isComplete()) {
            return false;
        }
        if ($this->type === self::TYPE_DEPARTMENT) {
            return $user->person_id === $this->created_by || hasRole('delete-tasks', $user);
        }
        return hasRole('delete-tasks', $user);
    }

    public function canReassign(User $user)
    {
        if ($this->isComplete()) {
            return false;
        }
        if ($this->type === self::TYPE_DEPARTMENT) {
            return $user->person_id === $this->created_by || hasRole('reassign-tasks', $user);
        }
        return hasRole('reassign-tasks', $user);
    }
    

    public function isBudgetApproval()
    {
        return (bool) $this->budgetno;
    }

    public function isApproved()
    {
        if ($this->is_approval) {
            return $this->isComplete() && $this->response = self::RESPONSE_APPROVED;
        }
        return $this->isComplete();
    }

    public function isDepartmentApproval()
    {
        return $this->type === self::TYPE_DEPARTMENT;
    }

    public function isComplete()
    {
        return $this->completed_by && $this->completed_at;
    }

    public function isSentBack()
    {
        return $this->response === self::RESPONSE_SENTBACK;
    }

    public function scopeDepartment($query)
    {
        return $query->where('type', self::TYPE_DEPARTMENT);
    }

    public function scopeNotSentBack($query)
    {
        return $query->where(function($query) {
            $query->whereNull('response')
                ->orWhere('response', '<>', self::RESPONSE_SENTBACK);
        });
    }

    public function assignee()
    {
        return $this->belongsTo(Person::class, 'assigned_to', 'person_id');
    }

    public function completer()
    {
        return $this->belongsTo(Person::class, 'completed_by', 'person_id');
    }

    public function creator()
    {
        return $this->belongsTo(Person::class, 'created_by', 'person_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
