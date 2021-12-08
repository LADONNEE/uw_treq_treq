<?php
namespace App\Mail;

class SentBackMail extends BaseTaskMailable
{
    protected function makeIntro(): string
    {
        return 'Your order was sent back. You may revise and re-submit it.';
    }

    protected function makeSubject($title): string
    {
        return "[TREQ] Sent Back: {$title}";
    }
}
