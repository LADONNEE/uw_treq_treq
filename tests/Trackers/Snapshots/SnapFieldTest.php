<?php

namespace Tests\Trackers\Snapshots;

use App\Trackers\Snapshots\SnapField;
use Tests\TestCase;

class SnapFieldTest extends TestCase
{
    public function test_it_instantiates()
    {
        $it = new SnapField('foo');

        $this->assertInstanceOf(SnapField::class, $it);
    }

    public function test_value_is_public_property()
    {
        $it = new SnapField('foo');

        $this->assertSame('foo', $it->value);
    }

    public function test_it_converts_null_to_empty_string()
    {
        $it = new SnapField(null);

        $this->assertSame('', $it->value);
    }

    public function test_it_compares_itself_to_another_snap_field()
    {
        $it = new SnapField('foo');
        $other = new SnapField('bar');

        $this->assertTrue($it->isChanged($other), 'value is different in $other');

        $third = new SnapField('foo');

        $this->assertFalse($it->isChanged($third), 'value is same in $other');
    }

    public function test_format_returns_the_value()
    {
        $it = new SnapField('foo');

        $this->assertSame('foo', $it->format());
    }
}
