<?php
namespace App\Mail;

use App\Models\Person;

class OrderSentBackMail extends BaseOrderMailable
{
    protected function ccPerson(): ?Person
    {
        return $this->order->assignee;
    }

    protected function makeIntro(): string
    {
        return 'Your order was sent back. You may revise and re-submit it.';
    }

    protected function makeSubject($title): string
    {
        return "[TREQ] Sent Back: {$title}";
    }
}
