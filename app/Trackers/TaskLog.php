<?php
namespace App\Trackers;

use App\Models\OrderLog;
use App\Models\Task;

class TaskLog
{
    public static function write(Task $task, $actor_id, $message)
    {
        $log = new OrderLog([
            'order_id' => $task->order_id,
            'actor_id' => $actor_id,
            'task_id' => $task->id,
            'message' => $message,
        ]);
        $log->save();
    }
}
