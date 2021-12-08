<?php
namespace App\Notifications;

use App\Models\Task;
use App\Utilities\MailSender;

class SendNotificationForTask
{
    private $sender;
    /**
     * @var Task
     */
    private $task;

    public function __construct(MailSender $sender, $task_id)
    {
        $this->sender = $sender;
        $this->task = Task::findOrFail($task_id);
    }

    public function run()
    {
        if ($this->task->order->isComplete()) {
            echo "Not sending, order is complete\n";
            return;
        }
        if ($this->task->order->isCanceled()) {
            echo "Not sending, order is canceled\n";
            return;
        }

        $this->task->fill([
            'notified_at' => null,
            'completed_by' => null,
            'completed_at' => null,
        ]);
        $this->task->save();

        if ($this->task->is_approval) {
            $notifier = new ApprovalNotifications($this->sender, now()->subYear(), now()->addYear());
        } else {
            $notifier = new TaskNotifications($this->sender, now()->subYear(), now()->addYear());
        }

        echo "Sending email to {$this->task->assignee->uwnetid}@uw.edu\n";

        $notifier->notifyItem($this->task->id);
    }
}
