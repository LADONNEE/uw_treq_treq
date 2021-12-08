<?php

namespace Tests\Trackers\Snapshots;

use App\Trackers\Snapshots\SnapTruncate;
use Tests\TestCase;

class SnapTruncateTest extends TestCase
{
    public function test_it_instantiates()
    {
        $it = new SnapTruncate(null);

        $this->assertInstanceOf(SnapTruncate::class, $it);
    }

    public function test_empty_values_are_stored_as_empty_string()
    {
        $it = new SnapTruncate(null);

        $this->assertSame('', $it->value);
    }

    public function test_values_are_stored_as_full_string()
    {
        $it = new SnapTruncate('this is an example value longer than 30 characters');

        $this->assertSame('this is an example value longer than 30 characters', $it->value);
    }

    public function test_format_returns_a_shortened_string_value()
    {
        $it = new SnapTruncate('this is an example value longer than 30 characters');

        $this->assertSame('this is an example value...', $it->format());
    }

    public function test_format_returns_full_value_when_it_is_under_limit()
    {
        $it = new SnapTruncate('this is a short example');

        $this->assertSame('this is a short example', $it->format());
    }

    public function test_constructor_can_take_other_length()
    {
        $it = new SnapTruncate('this is an example value longer than 30 characters', 22);

        $this->assertSame('this is an example...', $it->format());
    }

    public function test_comparison_is_based_on_full_length_value()
    {
        $it = new SnapTruncate('this is an example value longer than 30 characters');
        $other = new SnapTruncate('this is an example value longer than 30 characters, and only different at the end');

        $this->assertTrue($it->isChanged($other), 'value is different in $other');
    }
}
