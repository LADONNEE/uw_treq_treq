<?php

namespace Tests\Trackers\Snapshots;

use App\Trackers\Snapshots\SnapYesNo;
use Tests\TestCase;

class SnapYesNoTest extends TestCase
{
    public function test_it_instantiates()
    {
        $it = new SnapYesNo(null);

        $this->assertInstanceOf(SnapYesNo::class, $it);
    }

    public function test_empty_values_are_stored_as_empty_string()
    {
        $it = new SnapYesNo(null);

        $this->assertSame('', $it->value);

        $it = new SnapYesNo('');

        $this->assertSame('', $it->value);
    }

    public function test_truthy_values_are_stored_as_yes()
    {
        $it = new SnapYesNo(true);
        $this->assertSame('Yes', $it->value);

        $it = new SnapYesNo(1);
        $this->assertSame('Yes', $it->value);

        $it = new SnapYesNo('A String');
        $this->assertSame('Yes', $it->value);

        $it = new SnapYesNo('Y');
        $this->assertSame('Yes', $it->value);
    }

    public function test_falsey_values_are_stored_as_no()
    {
        $it = new SnapYesNo(false);
        $this->assertSame('No', $it->value);

        $it = new SnapYesNo(0);
        $this->assertSame('No', $it->value);
    }

    public function test_the_character_n_is_stored_as_no()
    {
        $it = new SnapYesNo('N');
        $this->assertSame('No', $it->value);
    }
}
