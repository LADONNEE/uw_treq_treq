<?php
namespace App\Mail;

use App\Contracts\RecordsMailSent;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMessage extends Mailable implements RecordsMailSent
{
    use Queueable, SerializesModels;

    public $wasSent = false;

    public function build()
    {
        $subject = '[TREQ] Third Message';
        return $this->subject($subject)
            ->view('email.test-message')
            ->text('email.test-message-text')
            ->with([
                'name' => 'Paul Hanisko',
                'secret' => 'The corn field lies fallow'
            ]);
    }

    public function wasSent(Carbon $sentAt): void
    {
        $this->wasSent = true;
    }
}
