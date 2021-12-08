<?php
namespace App\Mail;

use App\Models\Person;

class OrderCanceledMail extends BaseOrderMailable
{
    protected function ccPerson(): ?Person
    {
        return $this->order->assignee;
    }

    protected function makeIntro(): string
    {
        return 'Your order has been canceled.';
    }

    protected function makeSubject($title): string
    {
        return "[TREQ] Canceled: {$title}";
    }
}
