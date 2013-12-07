<?php
namespace TRex\Core;

use TRex\Core\resources\Bar;
use TRex\Core\resources\Foo;
use TRex\Iterator\IteratorAdapter;

/**
 * Class ObjectsTest
 * test class for Objects
 * @package TRex\Core
 */
class ObjectsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests getIterator.
     */
    public function testGetIterator()
    {
        $data = array('test');
        $objects = new Objects($data);
        $this->assertSame($data, $objects->getIterator()->toArray());
    }

    /**
     * Tests setIterator.
     */
    public function testSetIterator()
    {
        $data = array('test');
        $objects = new Objects();
        $objects->setIterator(new IteratorAdapter(new \ArrayIterator($data)));
        $this->assertSame($data, $objects->getIterator()->toArray());
    }

    /**
     * Tests Iterator interface implementation.
     */
    public function testIterator()
    {
        $objects = new Objects(array('test'));
        foreach ($objects as $key => $value) {
            $this->assertSame(0, $key);
            $this->assertSame('test', $value);
        }
    }

    /**
     * Tests ArrayAccess interface implementation.
     */
    public function testArrayAccess()
    {
        $objects = new Objects();
        $objects[] = 'test';
        $this->assertSame('test', $objects[0]);
    }

    /**
     * Tests Countable interface implementation.
     */
    public function testCountable()
    {
        $objects = new Objects;
        $objects[] = 'test';
        $this->assertCount(1, $objects);
    }

    /**
     * Tests reindex.
     */
    public function testReindex()
    {
        $data = array('a' => 0, 'b' => 1, 'c' => 2);
        $objects = new Objects($data);
        $this->assertSame(array(0, 1, 2), $objects->reindex()->toArray());
    }

    /**
     * Simple test for each.
     */
    public function testEach()
    {
        $objects = new Objects();
        $result = $objects->each(
            function () {
            }
        );
        $this->assertInstanceOf('TRex\Core\Objects', $result);
        $this->assertNotSame($objects, $result);
    }

    /**
     * Tests the value of $this in the closure in method each.
     * Case of an object.
     */
    public function testEachWithObjectByThis()
    {
        $data = array(new Foo(), new Bar());
        $objects = new Objects($data);
        $result = $objects->each(
            function () {
                return get_class($this);
            }
        );
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
        $objects = new Objects($data);
        $result = $objects->each(
            function ($value) {
                return get_class($value);
            }
        );
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
        $objects = new Objects($data);
        $result = $objects->each(
            function ($value, $key, $objects) {
                return get_class($objects[$key]);
            }
        );
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
        $objects = new Objects($data);
        $result = $objects->each(
            function ($value) {
                return $value + 1;
            }
        );
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
        $objects = new Objects($data);
        $result = $objects->each(
            function ($value, $key, $object) {
                return $object[$key] + 1;
            }
        );
        $this->assertCount(2, $result);
        $this->assertSame(1, $result[0]);
        $this->assertSame(2, $result[1]);
    }

    /**
     * Simple test for filter.
     */
    public function testFilter()
    {
        $objects = new Objects();
        $result = $objects->filter();
        $this->assertInstanceOf('TRex\Core\Objects', $result);
        $this->assertNotSame($objects, $result);
    }

    /**
     * Tests filter with default callback.
     */
    public function testFilterWithEmptyFilter()
    {
        $objects = new Objects(array('', 0, 1, false, null, '0', array()));
        $result = $objects->filter();
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
        $objects = new Objects($data);
        $result = $objects->filter(
            function () {
                return $this instanceof \TRex\Core\resources\Foo;
            }
        );
        $this->assertInstanceOf('TRex\Core\Objects', $result);
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
        $objects = new Objects($data);
        $result = $objects->filter(
            function ($value) {
                return $value instanceof \TRex\Core\resources\Foo;
            }
        );
        $this->assertInstanceOf('TRex\Core\Objects', $result);
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
        $objects = new Objects($data);
        $result = $objects->filter(
            function ($value, $key, $objects) {
                return $objects[$key] instanceof \TRex\Core\resources\Foo;
            }
        );
        $this->assertInstanceOf('TRex\Core\Objects', $result);
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
        $objects = new Objects($data);
        $result = $objects->filter(
            function ($value) {
                return $value === 'b';
            }
        );
        $this->assertInstanceOf('TRex\Core\Objects', $result);
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
        $objects = new Objects($data);
        $result = $objects->filter(
            function ($value, $key, $objects) {
                return $objects[$key] === 'b';
            }
        );
        $this->assertInstanceOf('TRex\Core\Objects', $result);
        $this->assertCount(1, $result);
        $this->assertSame($data[1], $result[1]);
    }
} 
