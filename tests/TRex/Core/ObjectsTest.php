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
     * Tests has in strict mode with value.
     */
    public function testHasSimpleOk()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertTrue($objects->has(1));
    }

    /**
     * Tests has in strict mode with no value.
     */
    public function testHasSimpleKo()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertFalse($objects->has(2));
    }

    /**
     * Tests has in non strict mode with value.
     */
    public function testHasNonStrict()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertTrue($objects->has(2, IObjects::NON_STRICT_SEARCH_MODE));
    }

    /**
     * Tests has in regex mode with value.
     */
    public function testHasRegEx()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertTrue($objects->has('/[0-9]/', IObjects::REGEX_SEARCH_MODE));
    }

    /**
     * Tests search in strict mode with value.
     */
    public function testSearchSimpleOk()
    {
        $objects = new Objects(array(1, '1'));
        $this->assertSame(array(0), $objects->search(1));
    }

    /**
     * Tests search in strict mode with no value.
     */
    public function testSearchSimpleKo()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertSame(array(), $objects->search(2));
    }

    /**
     * Tests search in non-strict mode with value.
     */
    public function testSearchNonStrict()
    {
        $objects = new Objects(array(1, '1'));
        $this->assertSame(array(0, 1), $objects->search(1, IObjects::NON_STRICT_SEARCH_MODE));
    }

    /**
     * Tests search in regex mode with value.
     */
    public function testSearchRegEx()
    {
        $objects = new Objects(array(1, '1'));
        $this->assertSame(array(0, 1), $objects->search('/[0-9]/', IObjects::REGEX_SEARCH_MODE));
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
} 
