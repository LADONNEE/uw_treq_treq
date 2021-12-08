<?php
namespace App\Notifications;

use App\Mail\TaskAssignedMail;
use App\Models\Task;

class TaskNotifications extends BaseNotification
{
    protected function todo()
    {
        return Task::where('updated_at', '>=', $this->cutoffAfter)
            ->where('created_at', '<', $this->cutoffBefore)
            ->whereNotNull('assigned_to')
            ->whereNull('notified_at')
            ->whereNull('completed_at')
            ->where('is_approval', 0)
            ->pluck('id')
            ->all();
    }

    protected function getPendingHeaderItem($id)
    {
        $task = Task::find($id);

        if (!$this->shouldSendTask($task)) {
            return null;
        }

        return new PendingEmailHeader($task->order, "{$task->assignee->uwnetid}@uw.edu", 'Task Assigned');
    }

    public function notifyItem($id)
    {
        $task = Task::find($id);

        if (!$this->shouldSendTask($task)) {
            return;
        }

        $this->sender->send($task->order_id, "{$task->assignee->uwnetid}@uw.edu", new TaskAssignedMail($task));
    }
}
