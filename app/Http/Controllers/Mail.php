<?php

namespace App\Http\Controllers;

use App\Mail\TestMessage;
use App\Utilities\MailSender;

class Mail extends Controller
{
    public function __invoke(MailSender $sender)
    {
        $m = new TestMessage();
        $sender->send(1, 'hanisko@uw.edu', $m);

        return ($m->wasSent) ? 'Mail sent.' : 'Send mail failed.';
    }
}
