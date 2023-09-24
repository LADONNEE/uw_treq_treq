<?php
namespace App\Models;

use App\Auth\User;
use Carbon\Carbon;

/**
 * @property integer $id
 * @property string $title
 * @property integer $person_id
 * @property string $purpose
 * @property string $relevance
 * @property string $arrangement
 * @property boolean $is_travel
 * @property boolean $is_food
 * @property boolean $is_gift_card
 * @property boolean $is_rsp
 * @property string $folder_url
 * @property string $folder_name
 * @property string $folder_deleted
 * @property Carbon $closed_at
 * @property integer $closed_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * ----------   Relationships   ----------
 * @property Person $closedBy
 * @property Order[] $orders
 * @property Trip $trip
 */
class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = [
        'title',
        'person_id',
        'purpose',
        'relevance',
        'arrangement',
        'is_travel',
        'is_food',
        'is_gift_card',
        'is_rsp',
        'folder_url',
        'folder_name',
        'folder_deleted',
        'closed_at',
        'closed_by',
    ];
    protected $casts = [
        'closed_at',
        'created_at',
        'updated_at',
    ];

    public function canClose()
    {
        if (!$this->exists) {
            return false;
        }
        return ! Order::where('project_id', $this->id)
            ->whereNotIn('stage', [Order::STAGE_COMPLETE, Order::STAGE_CANCELED])
            ->count();
    }

    public function close(User $user)
    {
        if (!$this->closed_at) {
            $this->closed_at = now();
            $this->closed_by = $user->person_id;
            $this->save();
        }
    }

    public function folderDeleted(User $user)
    {
        if (!$this->folder_deleted) {
            $this->folder_deleted = 'by ' . eFirstLast($user) . ' ' . now()->format('n/j/Y');
            $this->save();
        }
    }

    public function open()
    {
        if ($this->closed_at) {
            $this->closed_at = null;
            $this->closed_by = null;
            $this->save();
        }
    }

    public function pageTitle(): string
    {
        return projectNumber($this->id) . ' - ' . $this->title ?: 'Untitiled';
    }

    public function titleFromTrip(?Trip $trip = null)
    {
        $trip = $trip ?? $this->trip;
        if ($trip) {
            $this->title = 'Travel: ' . $trip->traveler . ' > ' . $trip->destination;
        } else {
            $this->title = 'Travel: ' . eFirstLast($this->person_id);
        }
    }

    public function closedBy()
    {
        return $this->hasOne(Person::class, 'person_id', 'closed_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'project_id', 'id');
    }

    public function trip()
    {
        return $this->hasOne(Trip::class, 'project_id', 'id');
    }
}
