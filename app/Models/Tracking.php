<?php
namespace App\Models;

use App\Workflows\StageToTaskType;
use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property string   $last_action
 * @property string   $last_actor
 * @property Carbon   $last_at
 * @property string   $next_action
 * @property string   $next_actors
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 */
class Tracking extends Model
{
    /**
     * @var StageToTaskType|null
     */
    public static $map;

    protected $table = 'tracking';
    protected $fillable = [
        'order_id',
        'last_action',
        'last_actor',
        'last_at',
        'next_action',
        'next_actors',
    ];
    protected $casts = [
        'last_at',
        'created_at',
        'updated_at',
    ];

    public function track(Order $order)
    {
        $tr = $this->getTrackingLast($order);
        $this->last_action = $tr->action;
        $this->last_actor = $tr->actor;
        $this->last_at = $tr->at;

        $tn = new TrackingNext($order, $this->stageToTaskType($order->stage));
        $this->next_action = $tn->action;
        $this->next_actors = $tn->actors;

        $this->save();
    }

    private function getTrackingLast(Order $order)
    {
        $lastTask = Task::where('order_id', $order->id)
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->first();

        return new TrackingLast($order, $lastTask);
    }

    private function stageToTaskType($stage): string
    {
        if (!self::$map instanceof StageToTaskType) {
            self::$map = new StageToTaskType();
        }
        return self::$map->taskType($stage);
    }
}
