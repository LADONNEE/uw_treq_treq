<?php

namespace Tests\Trackers\Snapshots;

use App\Trackers\Snapshots\SnapPerson;
use Tests\TestCase;

class SnapPersonTest extends TestCase
{
    public function test_it_instantiates()
    {
        $it = new SnapPerson(null);

        $this->assertInstanceOf(SnapPerson::class, $it);
    }

    public function test_values_are_stored_as_integers()
    {
        $it = new SnapPerson('999');

        $this->assertSame(999, $it->value);
    }

    public function test_empty_values_are_stored_as_empty_string()
    {
        $it = new SnapPerson(null);

        $this->assertSame('', $it->value);
    }

    public function test_string_vs_integer_values_are_not_changes()
    {
        $it = new SnapPerson('1000');
        $other = new SnapPerson(1000);

        $this->assertFalse($it->isChanged($other), 'value is same in $other');

        $third = new SnapPerson('1002');

        $this->assertTrue($it->isChanged($third), 'value is changed in $third');
    }

    public function test_format_returns_the_value()
    {
        $originalStrategy = SnapPerson::$personFormatter;
        SnapPerson::$personFormatter = [$this, 'stubPersonFormat'];

        $it = new SnapPerson(99);

        $this->assertSame('I was formatted', $it->format());

        SnapPerson::$personFormatter = $originalStrategy;
    }

    public function stubPersonFormat()
    {
        return 'I was formatted';
    }
}
