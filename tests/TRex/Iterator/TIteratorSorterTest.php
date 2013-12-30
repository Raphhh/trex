<?php
namespace TRex\Iterator;

use TRex\Core\Objects;

/**
 * Class TIteratorSorterTest
 * Test class for TIteratorSorter
 * @package TRex\Iterator
 * @todo work with mock of TIteratorSorter
 */
class TIteratorSorterTest extends \PHPUnit_Framework_TestCase
{

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

        $objects = new Objects($data);
        $this->assertTrue(asort($data, SORT_NATURAL));
        $this->assertSame($data, $objects->sort()->toArray());
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

        $objects = new Objects($data);
        $this->assertTrue(ksort($data, SORT_DESC));
        $this->assertSame($data, $objects->sort(new SortType(SortType::KEY_SORT_TYPE), SORT_DESC)->toArray());
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

        $objects = new Objects($data);
        $this->assertTrue(sort($data, SORT_STRING));
        $this->assertSame($data, $objects->sort(new SortType(SortType::VALUE_SORT_TYPE), SORT_STRING)->toArray());
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

        $objects = new Objects($data);
        $this->assertTrue(uasort($data, $callback));
        $this->assertSame($data, $objects->sort(new SortType(SortType::ASSOCIATIVE_SORT_TYPE), $callback)->toArray());
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
        $objects = new Objects($data);
        $this->assertSame(array_reverse($data, true), $objects->reverse()->toArray());
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
        $objects = new Objects($data);
        $this->assertSame(array_reverse($data, false), $objects->reverse(false)->toArray());
    }
}
