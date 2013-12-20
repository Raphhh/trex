<?php
namespace TRex\Core;

use TRex\Iterator\IteratorAdapter;

/**
 * Class ObjectsTest
 * test class for Objects
 * @package TRex\Core
 */
class ObjectsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Extends Object
     */
    public function testInheritance()
    {
        $this->assertInstanceOf('TRex\Core\Object', new Objects());
    }

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
     * Test constructor argument with a JSON.
     */
    public function testJsonHydration()
    {
        $objects = new Objects('{"a": "test"}');
        $this->assertSame('test', $objects['a']);
    }

    /**
     * Test constructor argument with a stdClass object.
     */
    public function testStdObjectHydration()
    {
        $object = new \stdClass();
        $object->a = 'test';

        $objects = new Objects($object);
        $this->assertSame('test', $objects['a']);
    }

    /**
     * Tests getByIndex.
     */
    public function testGetByIndex()
    {
        $data = array(1 => 'b', 0 => 'a', 2 => 'c');
        $objects = new Objects($data);
        $this->assertSame('a', $objects->getByIndex(1));
        $this->assertSame('a', $objects->getByIndex(-2));
    }

    /**
     * Tests getByIndex.
     */
    public function testGetByIndexNull()
    {
        $data = array(1 => 'b', 0 => 'a', 2 => 'c');
        $objects = new Objects($data);
        $this->assertNull($objects->getByIndex(10));
        $this->assertNull($objects->getByIndex(-10));
    }

    /**
     * Tests first.
     */
    public function testFirst()
    {
        $data = array('a', 'b');
        $objects = new Objects($data);
        $this->assertSame('a', $objects->first());
    }

    /**
     * Tests first.
     */
    public function testFirstNull()
    {
        $objects = new Objects();
        $this->assertnull($objects->first());
    }

    /**
     * Tests last.
     */
    public function testLast()
    {
        $data = array('a', 'b');
        $objects = new Objects($data);
        $this->assertSame('b', $objects->last());

        $data = array('a');
        $objects = new Objects($data);
        $this->assertSame('a', $objects->last());
    }

    /**
     * Tests last.
     */
    public function testLastNull()
    {
        $objects = new Objects();
        $this->assertnull($objects->last());
    }

    /**
     * Tests addFirst with index keys
     */
    public function testAddFirst()
    {
        $data = array('a', 'b');
        $objects = new Objects($data);
        $objects->addFirst('c');
        array_unshift($data, 'c');
        $this->assertSame($data, $objects->toArray());
    }

    /**
     * Tests addLast with index keys
     */
    public function testAddLast()
    {
        $data = array('a', 'b');
        $objects = new Objects($data);
        $objects->addLast('c');
        array_push($data, 'c');
        $this->assertSame($data, $objects->toArray());
    }

    /**
     * Tests addFirst with assoc keys
     */
    public function testAddFirstWithAssociativeKey()
    {
        $data = array('a' => 'b', 'd' => 'e');
        $objects = new Objects($data);
        $objects->addFirst('c');
        array_unshift($data, 'c');
        $this->assertSame($data, $objects->toArray());
    }

    /**
     * Tests addLast with assoc keys
     */
    public function testAddLastWithAssociativeKey()
    {
        $data = array('a' => 'b', 'd' => 'e');
        $objects = new Objects($data);
        $objects->addLast('c');
        array_push($data, 'c');
        $this->assertSame($data, $objects->toArray());
    }

    /**
     * Tests removeFirst with index keys.
     */
    public function testRemoveFirst()
    {
        $data = array('a', 'b');
        $objects = new Objects($data);
        $objects->removeFirst();
        array_shift($data);
        $this->assertSame($data, $objects->toArray());
    }

    /**
     * Tests removeFirst with assoc keys.
     */
    public function testRemoveLast()
    {
        $data = array('a', 'b');
        $objects = new Objects($data);
        $objects->removeLast();
        array_pop($data);
        $this->assertSame($data, $objects->toArray());
    }

    /**
     * Tests removeLast with index keys.
     */
    public function testRemoveFirstWithAssociativeKey()
    {
        $data = array('a' => 'b', 'd' => 'e');
        $objects = new Objects($data);
        $objects->removeFirst();
        array_shift($data);
        $this->assertSame($data, $objects->toArray());
    }

    /**
     * Tests removeLast with assoc keys.
     */
    public function testRemoveLastWithAssociativeKey()
    {
        $data = array('a' => 'b', 'd' => 'e');
        $objects = new Objects($data);
        $objects->removeLast();
        array_pop($data);
        $this->assertSame($data, $objects->toArray());
    }
}
