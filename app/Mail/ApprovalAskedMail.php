<?php
namespace App\Mail;

class ApprovalAskedMail extends BaseTaskMailable
{
    protected function makeIntro(): string
    {
        return 'We need your approval of an order.';
    }

    protected function makeSubject($title): string
    {
        return "[TREQ] Approval Needed: {$title}";
    }
}
