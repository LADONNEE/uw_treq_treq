<?php
namespace App\Console\Commands;

use App\Notifications\SendNotificationForTask;
use App\Utilities\MailSender;
use Illuminate\Console\Command;

class NotifyTask extends Command
{
    protected $signature = 'notify:task {task_id : id of Task record used to generate an email notification}';

    protected $description = 'Send single email for a Task. Use for testing email setup.';

    public function handle(MailSender $sender)
    {
        $job = new SendNotificationForTask($sender, $this->argument('task_id'));
        $job->run();
    }
}
