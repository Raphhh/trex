<?php
namespace TRex\Core;

use TRex\Core\resources\Bar;
use TRex\Core\resources\Foo;

/**
 * Class TObjectsModifierTest
 * Class test for TObjectsModifier.
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TObjectsModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests extract.
     */
    public function testExtractDefault()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $objects = new resources\Foos($data);
        $result = $objects->extract(1);

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(array_slice($data, 1, 3, true), $result->toArray());
    }

    public function testExtractWithLength()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $objects = new resources\Foos($data);
        $result = $objects->extract(1, 2);

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(array_slice($data, 1, 2, true), $result->toArray());
    }

    public function testExtractWithoutPreservedKeys()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $objects = new resources\Foos($data);
        $result = $objects->extract(1, 0, false);

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(array_slice($data, 1, 3, false), $result->toArray());
    }

    /**
     * Simple test for each.
     */
    public function testEach()
    {
        $objects = new resources\Foos();
        $result = $objects->each(
            function () {
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertNotSame($objects, $result);
    }

    /**
     * Tests the value of $this in the closure in method each.
     * Case of an object.
     */
    public function testEachWithObjectByThis()
    {
        $data = array(new Foo(), new Bar());
        $objects = new resources\Foos($data);
        $result = $objects->each(
            function () {
                return get_class($this);
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(2, $result);
        $this->assertSame('TRex\Core\resources\Foo', $result[0]);
        $this->assertSame('TRex\Core\resources\Bar', $result[1]);
    }

    /**
     * Tests the value of the first param in the closure in method each.
     * Case of an object.
     */
    public function testEachWithObjectByValue()
    {
        $data = array(new Foo(), new Bar());
        $objects = new resources\Foos($data);
        $result = $objects->each(
            function ($value) {
                return get_class($value);
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(2, $result);
        $this->assertSame('TRex\Core\resources\Foo', $result[0]);
        $this->assertSame('TRex\Core\resources\Bar', $result[1]);
    }

    /**
     * Tests the value of the last params in the closure in method each.
     * Case of an object.
     */
    public function testEachWithObjectByKeyAndObjects()
    {
        $data = array(new Foo(), new Bar());
        $objects = new resources\Foos($data);
        $result = $objects->each(
            function ($value, $key, $objects) {
                return get_class($objects[$key]);
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(2, $result);
        $this->assertSame('TRex\Core\resources\Foo', $result[0]);
        $this->assertSame('TRex\Core\resources\Bar', $result[1]);
    }

    /**
     * Tests the value of the first param in the closure in method each.
     * Case of an object.
     */
    public function testEachWithScalarByValue()
    {
        $data = array(0, 1);
        $objects = new resources\Foos($data);
        $result = $objects->each(
            function ($value) {
                return $value + 1;
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(2, $result);
        $this->assertSame(1, $result[0]);
        $this->assertSame(2, $result[1]);
    }

    /**
     * Tests the value of the last params in the closure in method each.
     * Case of an object.
     */
    public function testEachWithScalarByKeyAndObjects()
    {
        $data = array(0, 1);
        $objects = new resources\Foos($data);
        $result = $objects->each(
            function ($value, $key, $object) {
                return $object[$key] + 1;
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(2, $result);
        $this->assertSame(1, $result[0]);
        $this->assertSame(2, $result[1]);
    }

    /**
     * Simple test for filter.
     */
    public function testFilter()
    {
        $objects = new resources\Foos();
        $result = $objects->filter();

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertNotSame($objects, $result);
    }

    /**
     * Tests filter with default callback.
     */
    public function testFilterWithEmptyFilter()
    {
        $objects = new resources\Foos(array('', 0, 1, false, null, '0', array()));
        $result = $objects->filter();

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(1, $result);
        $this->assertSame(1, $result[2]);
    }

    /**
     * Tests the value of $this in the closure in method filter.
     * Case of an object.
     */
    public function testFilterWithObjectByThis()
    {
        $data = array(new Bar(), new Foo());
        $objects = new resources\Foos($data);
        $result = $objects->filter(
            function () {
                return $this instanceof Foo;
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(1, $result);
        $this->assertSame($data[1], $result[1]);
    }

    /**
     * Tests the value of the first param in the closure in method filter.
     * Case of an object.
     */
    public function testFilterWithObjectByValue()
    {
        $data = array(new Bar(), new Foo());
        $objects = new resources\Foos($data);
        $result = $objects->filter(
            function ($value) {
                return $value instanceof Foo;
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(1, $result);
        $this->assertSame($data[1], $result[1]);
    }

    /**
     * Tests the value of the last params in the closure in method filter.
     * Case of an object.
     */
    public function testFilterWithObjectByKeyAndObjects()
    {
        $data = array(new Bar(), new Foo());
        $objects = new resources\Foos($data);
        $result = $objects->filter(
            function ($value, $key, $objects) {
                return $objects[$key] instanceof Foo;
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(1, $result);
        $this->assertSame($data[1], $result[1]);
    }

    /**
     * Tests the value of the first param in the closure in method filter.
     * Case of a scalar value.
     */
    public function testFilterWithScalarByValue()
    {
        $data = array('a', 'b');
        $objects = new resources\Foos($data);
        $result = $objects->filter(
            function ($value) {
                return $value === 'b';
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(1, $result);
        $this->assertSame($data[1], $result[1]);
    }

    /**
     * Tests the value of the last params in the closure in method filter.
     * Case of a scalar value.
     */
    public function testFilterWithScalarByKeyAndObjects()
    {
        $data = array('a', 'b');
        $objects = new resources\Foos($data);
        $result = $objects->filter(
            function ($value, $key, $objects) {
                return $objects[$key] === 'b';
            }
        );

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertCount(1, $result);
        $this->assertSame($data[1], $result[1]);
    }
}
