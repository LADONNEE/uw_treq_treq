<?php

namespace Tests\Models;

use App\Models\Item;
use Tests\TestCase;

class ItemAmountTest extends TestCase
{
    public function test_it_stores_an_amount()
    {
        $it = new Item();
        $it->amount = 9;

        $this->assertEquals(9, $it->amount);
    }

    public function test_it_stores_an_amount_as_decimal_value()
    {
        $it = new Item();
        $it->amount = '2';

        $this->assertSame(2.0, $it->amount);
    }

    public function test_it_stores_null_input_as_null()
    {
        $it = new Item();
        $it->amount = null;

        $this->assertNull($it->amount);
    }

    public function test_it_stores_empty_string_input_as_null()
    {
        $it = new Item();
        $it->amount = '';

        $this->assertNull($it->amount);
    }

    public function test_it_stores_non_numeric_input_as_null()
    {
        $it = new Item();
        $it->amount = 'foo';

        $this->assertNull($it->amount);
    }

    public function test_it_stores_negative_amount()
    {
        $it = new Item();
        $it->amount = '-50';

        $this->assertSame(-50.0, $it->amount);
    }

    public function test_it_rounds_amount_to_two_decimal_places()
    {
        $it = new Item();
        $it->amount = '50.12345';

        $this->assertSame(50.12, $it->amount);
    }

    public function test_it_rounds_negative_amount_to_two_decimal_places()
    {
        $it = new Item();
        $it->amount = '-50.12345';

        $this->assertSame(-50.12, $it->amount);
    }
}
