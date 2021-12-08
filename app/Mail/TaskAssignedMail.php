<?php
namespace App\Mail;

class TaskAssignedMail extends BaseTaskMailable
{
    protected function makeIntro(): string
    {
        return 'A task has been assigned to you.';
    }

    protected function makeSubject($title): string
    {
        return "[TREQ] New Task: {$title}";
    }
}
