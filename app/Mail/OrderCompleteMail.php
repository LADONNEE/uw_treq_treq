<?php
namespace App\Mail;

use App\Models\Person;

class OrderCompleteMail extends BaseOrderMailable
{
    protected function ccPerson(): ?Person
    {
        return $this->order->assignee;
    }

    protected function makeIntro(): string
    {
        return 'Your order is now complete.';
    }

    protected function makeSubject($title): string
    {
        return "[TREQ] Complete: {$title}";
    }
}
