<?php
namespace App\Utilities;

use App\Models\Order;
use Illuminate\Session\Store as SessionStore;

class FlashMessage
{
    const SESSION_KEY = 'treq_flash_message';

    public $message;
    public $order_id;
    public $linkText;
    public $style = 'info';

    private $session;

    public function __construct(?SessionStore $session = null)
    {
        $this->session = $session ?? app('session')->driver();
    }

    public function store($message = null, ...$args)
    {
        $this->message = $message;
        foreach ($args as $arg) {
            if ($arg instanceof Order) {
                $this->order_id = $arg->id;
                $this->linkText = $arg->title();
            } else {
                $this->style = $arg;
            }
        }

        $this->session->flash(self::SESSION_KEY, [
            'message' => $this->message,
            'order_id' => $this->order_id,
            'linkText' => $this->linkText,
            'style' => $this->style,
        ]);
    }

    public function retrieve()
    {
        $action = $this->session->pull(self::SESSION_KEY);
        $this->message = $action['message'] ?? null;
        $this->order_id = $action['order_id'] ?? null;
        $this->linkText = $action['linkText'] ?? null;
        $this->style = $action['style'] ?? null;
    }

    public function hasMessage()
    {
        return (boolean) $this->session->has(self::SESSION_KEY);
    }
}
