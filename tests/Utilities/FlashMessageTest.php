<?php

namespace Tests\Utilities;

use App\Models\Order;
use App\Utilities\FlashMessage;
use Tests\TestCase;

class FlashMessageTest extends TestCase
{
    public function test_it_instantiates()
    {
        $it = $this->makeIt();

        $this->assertInstanceOf(FlashMessage::class, $it);
    }

    public function test_it_takes_message_as_argument()
    {
        $it = $this->makeIt();

        $it->store('Hello World');

        $this->assertSame('Hello World', $it->message);
    }

    public function test_it_takes_style_as_argument()
    {
        $it = $this->makeIt();

        $it->store('Hello World', 'danger');

        $this->assertSame('Hello World', $it->message);
        $this->assertSame('danger', $it->style);
    }

    public function test_it_takes_order_as_argument()
    {
        $it = $this->makeIt();

        $order = new Order();
        $order->id = 999;

        $it->store('Hello World', $order);

        $this->assertSame('Hello World', $it->message);
        $this->assertEquals(999, $it->order_id);
    }

    public function test_setting_order_sets_the_link_text()
    {
        $it = $this->makeIt();

        $order = new Order();
        $order->id = 999;

        $it->store('Hello World', $order);

        $this->assertSame('Hello World', $it->message);
        $this->assertSame('Order (999)', $it->linkText);
    }

    public function test_order_of_additional_arguments_does_not_matter()
    {
        $it = $this->makeIt();

        $order = new Order();
        $order->id = 999;

        $it->store('Hello World', $order, 'danger');

        $this->assertSame('Hello World', $it->message);
        $this->assertEquals(999, $it->order_id);
        $this->assertSame('danger', $it->style);

        $it->store('Hello World', 'info', $order);

        $this->assertSame('Hello World', $it->message);
        $this->assertEquals(999, $it->order_id);
        $this->assertSame('info', $it->style);
    }

    public function test_stored_values_can_be_retrieved_later()
    {
        $first = $this->makeIt();
        $order = new Order();
        $order->id = 999;
        $first->store('Hello World', $order, 'info');

        $it = $this->makeIt();
        $it->retrieve();

        $this->assertSame('Hello World', $it->message);
        $this->assertEquals(999, $it->order_id);
        $this->assertSame('Order (999)', $it->linkText);
        $this->assertSame('info', $it->style);
    }

    public function test_retrieve_clears_flashed_message()
    {
        $first = $this->makeIt();
        $order = new Order();
        $order->id = 999;
        $first->store('Hello World', $order, 'info');

        $second = $this->makeIt();
        $this->assertTrue($second->hasMessage(), 'Has message before retrieval');
        $second->retrieve();
        $this->assertFalse($second->hasMessage(), 'Has message after retrieval = false');

        $it = $this->makeIt();
        $it->retrieve();
        $this->assertFalse($it->hasMessage(), 'Has message in next instance = false');
    }

    private function makeIt()
    {
        return new FlashMessage(session()->driver('array'));
    }
}
