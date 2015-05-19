<?php

namespace Nexmo\Tests\Entity;

use Nexmo\Entity\Collection;
use Nexmo\Tests\TestCase;

class CollectionTest extends TestCase
{
    public function testConstructor()
    {
        $arr = ['foo' => 'bar'];
        $collection = new Collection($arr);
        $this->assertSame($arr, $collection->all());

        $collection2 = new Collection($collection);
        $this->assertEquals($collection, $collection2);
    }

    public function testGet()
    {
        $collection = new Collection(['foo' => 'bar']);
        $this->assertSame('bar', $collection->get('foo'));
        $this->assertNull($collection->get('derp'));
    }

    public function testGetArray()
    {
        $collection = new Collection([
            'foo' => ['bar', 'baz'],
        ]);
        $this->assertSame(['bar', 'baz'], $collection->getArray('foo'));
    }

    public function testGetArrayMap()
    {
        $collection = new Collection([
            'foo' => ['bar', 'baz'],
        ]);
        $list = $collection->getArray('foo', function ($item) {
            return new Collection($item);
        });
        $this->assertCount(2, $list);
        $this->assertContainsOnlyInstancesOf('\Nexmo\Entity\Collection', $list);
    }

    public function testGetArrayInvalidKey()
    {
        $collection = new Collection([]);
        $this->assertTrue(is_array($collection->getArray('foo')));
    }

    public function testHas()
    {
        $collection = new Collection(['foo' => 'bar']);
        $this->assertTrue($collection->has('foo'));
        $this->assertFalse($collection->has('derp'));
    }

    public function testArrayAccessExists()
    {
        $collection = new Collection(['foo' => 'bar']);
        $this->assertTrue(isset($collection['foo']));
        $this->assertFalse(isset($collection['derp']));
    }

    public function testArrayAccessGet()
    {
        $collection = new Collection(['foo' => 'bar']);
        $this->assertSame('bar', $collection['foo']);
        $this->assertNull($collection['derp']);
    }

    public function testArrayAccessSetDoesNothing()
    {
        $collection = new Collection(['foo' => 'bar']);
        $collection['foo'] = 'derp';
        $this->assertSame('bar', $collection['foo']);
    }

    public function testArrayAccessUnsetDoesNothing()
    {
        $collection = new Collection(['foo' => 'bar']);
        unset($collection['foo']);
        $this->assertSame('bar', $collection['foo']);
    }

    public function testIterable()
    {
        $collection = new Collection(['foo' => 'bar']);
        $this->assertInstanceOf('\Traversable', $collection);
        foreach ($collection as $key => $value) {
            $this->assertSame('foo', $key);
            $this->assertSame('bar', $value);
        }
    }

    public function testCount()
    {
        $collection = new Collection(['foo' => 'bar']);
        $this->assertCount(1, $collection);
    }
}
