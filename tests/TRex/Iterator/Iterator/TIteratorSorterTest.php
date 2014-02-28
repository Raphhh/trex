<?php
namespace TRex\Iterator;

use TRex\Iterator\Iterator\SortType;

/**
 * Class TIteratorSorterTest
 * Test class for TIteratorSorter
 * @package TRex\Iterator
 */
class TIteratorSorterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests reindex.
     */
    public function testReindex()
    {
        $data = array('a' => 0, 'b' => 1, 'c' => 2);
        $objects = new resources\Foos($data);
        $result = $objects->reindex();

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(array(0, 1, 2), $result->toArray());
    }

    /**
     * Tests sort with default params.
     */
    public function testSortDefault()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );

        $objects = new resources\Foos($data);
        $result = $objects->sort();

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertTrue(asort($data, SORT_NATURAL));
        $this->assertSame($data, $result->toArray());
    }

    /**
     * Tests sort with KEY_SORT_TYPE.
     */
    public function testSortKey()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );

        $objects = new resources\Foos($data);
        $result = $objects->sort(new SortType(SortType::KEY_SORT_TYPE), SORT_DESC);

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertTrue(ksort($data, SORT_DESC));
        $this->assertSame($data, $result->toArray());
    }

    /**
     * Tests sort with VALUE_SORT_TYPE.
     */
    public function testSortValue()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );

        $objects = new resources\Foos($data);
        $result = $objects->sort(new SortType(SortType::VALUE_SORT_TYPE), SORT_STRING);

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertTrue(sort($data, SORT_STRING));
        $this->assertSame($data, $result->toArray());
    }

    /**
     * Tests sort with a callback.
     */
    public function testSortCallback()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $callback = function ($firstValue, $followingValue) {
            if ($firstValue == $followingValue) {
                return 0;
            }
            return ($firstValue < $followingValue) ? -1 : 1;
        };

        $objects = new resources\Foos($data);
        $result = $objects->sort(new SortType(SortType::ASSOCIATIVE_SORT_TYPE), $callback);

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertTrue(uasort($data, $callback));
        $this->assertSame($data, $result->toArray());
    }

    /**
     * Tests reverse with default params.
     * keys are preserved.
     */
    public function testReverseDefault()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $objects = new resources\Foos($data);
        $result = $objects->reverse();

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(array_reverse($data, true), $result->toArray());
    }

    /**
     * Tests reverse when keys are not preserved.
     */
    public function testReverseWithoutPreservedKeys()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $objects = new resources\Foos($data);
        $result = $objects->reverse(false);

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(array_reverse($data, false), $result->toArray());
    }
}
