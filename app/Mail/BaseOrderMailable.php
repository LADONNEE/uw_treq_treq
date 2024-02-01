<?php
namespace App\Mail;

use App\Contracts\ProvidesMetadata;
use App\Contracts\RecordsMailSent;
use App\Models\Order;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Mail\Mailable;

abstract class BaseOrderMailable extends Mailable implements ProvidesMetadata, RecordsMailSent
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Provide email subject line
     * Optionally using the provided Project $title
     * @param string $title
     * @return string
     */
    abstract protected function makeSubject($title): string;

    /**
     * First line to be included in email body
     * @return string
     */
    protected function makeIntro(): string
    {
        return 'Your review and response is needed on this order.';
    }

    /**
     * Blade template name for HTML version of this email
     * example: return 'email.task-default';
     * @return string
     */
    protected function htmlView(): string
    {
        return 'email.order-notify';
    }

    /**
     * Blade template name for text only version of this email
     * @return string
     */
    protected function textView(): string
    {
        return $this->htmlView() . '-text';
    }

    public function build()
    {
        if ($this->order && $this->order->project) {
            $title = $this->order->project->title;
        } else {
            $title = "Order #{$this->order->id}";
        }
        $mailable = $this->subject($this->makeSubject($title))
            ->view($this->htmlView())
            ->text($this->textView())
            ->with([
                'intro' => $this->makeIntro(),
                'projectTitle' => $title,
                'projectNumber' => projectNumber($this->order),
                'type' => $this->order->typeName(),
                'appName' => config('app.name'),
                'url' => route('order', $this->order->id),
                'submitted' => eDate($this->order->submitted_at, 'D, M j, Y \a\t g:i A'),
            ]);

        $cc = $this->ccPerson();
        if ($cc && $cc->uwnetid) {
            $mailable->cc($cc->uwnetid . '@' . config('custom.scl_email_domain'), eFirstLast($cc));
        }

        return $mailable;
    }

    public function getMetadata(): array
    {
        return [];
    }

    public function wasSent(Carbon $sentAt): void
    {
        $this->order->notified_at = $sentAt;
        $this->order->save();
    }

    /**
     * Optionally return a Person object to be CC'd on this email
     * @return Person|null
     */
    protected function ccPerson(): ?Person
    {
        return null;
    }
}
