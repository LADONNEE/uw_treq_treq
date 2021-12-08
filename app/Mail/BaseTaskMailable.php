<?php
namespace App\Mail;

use App\Models\Task;
use Carbon\Carbon;

abstract class BaseTaskMailable extends BaseOrderMailable
{
    protected $task;

    public function __construct(Task $task)
    {
        parent::__construct($task->order);
        $this->task = $task;
    }

    public function getMetadata(): array
    {
        return [
            'task_id' => $this->task->id,
        ];
    }

    public function wasSent(Carbon $sentAt): void
    {
        $this->task->notified_at = $sentAt;
        $this->task->save();
    }
}
