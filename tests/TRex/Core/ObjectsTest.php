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
} 
