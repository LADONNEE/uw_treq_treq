<?php
namespace App\Notifications;

use App\Mail\ApprovalAskedMail;
use App\Models\Task;

class ApprovalNotifications extends BaseNotification
{
    protected function todo()
    {
        return Task::where('updated_at', '>=', $this->cutoffAfter)
            ->where('created_at', '<', $this->cutoffBefore)
            ->whereNotNull('assigned_to')
            ->whereNull('notified_at')
            ->whereNull('completed_at')
            ->where('is_approval', 1)
            ->pluck('id')
            ->all();
    }

    protected function getPendingHeaderItem($id)
    {
        $task = Task::find($id);

        if (!$this->shouldSendTask($task)) {
            return null;
        }

        $email = ($task->assignee && $task->assignee->uwnetid) ? "{$task->assignee->uwnetid}@uw.edu" : "(missing email)";

        return new PendingEmailHeader($task->order, $email, 'Need Approval');
    }

    public function notifyItem($id)
    {
        $task = Task::find($id);

        if (!$this->shouldSendTask($task)) {
            return;
        }

        $email = ($task->assignee && $task->assignee->uwnetid) ? "{$task->assignee->uwnetid}@uw.edu" : "(missing email)";

        $this->sender->send($task->order_id, $email, new ApprovalAskedMail($task));
    }
}
