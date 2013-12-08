<?php
namespace TRex\Core;

/**
 * Class TObjectsComparatorTest
 * Calss test for TObjectsComparator
 * @package TRex\Core
 * @todo work with mock...
 */
class TObjectsComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests merge.
     */
    public function testMerge()
    {
        $data1 = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $data2 = array(
            1 => 'd',
            2 => 'e',
            'a' => 2,
            'f' => 3,
        );
        $data3 = array(
            1 => 'h',
            3 => '1',
            'a' => 4,
            'g' => 5,
        );

        $objects = new Objects($data1);
        $this->assertSame(
            array_merge($data1, $data2, $data3),
            $objects->merge(new Objects($data2), new Objects($data3))->toArray()
        );
    }

    /**
     * Tests mergeA.
     */
    public function testMergeA()
    {
        $data1 = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $data2 = array(
            1 => 'd',
            2 => 'e',
            'a' => 2,
            'f' => 3,
        );
        $data3 = array(
            1 => 'h',
            3 => '1',
            'a' => 4,
            'g' => 5,
        );

        $objects = new Objects($data1);
        $this->assertSame(
            array_replace($data3, $data2, $data1),
            $objects->mergeA(new Objects($data2), new Objects($data3))->toArray()
        );
    }

    /**
     * Tests diff.
     */
    public function testDiff()
    {
        $data1 = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $data2 = array(
            1 => 'd',
            2 => 'e',
            'a' => 2,
            'f' => 3,
        );
        $data3 = array(
            1 => 'h',
            3 => '1',
            'a' => 4,
            'g' => 5,
        );

        $objects = new Objects($data1);
        $this->assertSame(
            array_diff($data1, $data2, $data3),
            $objects->diff(new Objects($data2), new Objects($data3))->toArray()
        );
    }

    /**
     * Tests diffA.
     */
    public function testDiffA()
    {
        $data1 = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $data2 = array(
            1 => 'd',
            2 => 'e',
            'a' => 2,
            'f' => 3,
        );
        $data3 = array(
            1 => 'h',
            3 => '1',
            'a' => 4,
            'g' => 5,
        );

        $objects = new Objects($data1);
        $this->assertSame(
            array_diff_assoc($data1, $data2, $data3),
            $objects->diffA(new Objects($data2), new Objects($data3))->toArray()
        );
    }

    /**
     * Tests diffK.
     */
    public function testDiffK()
    {
        $data1 = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $data2 = array(
            1 => 'd',
            2 => 'e',
            'a' => 2,
            'f' => 3,
        );
        $data3 = array(
            1 => 'h',
            3 => '1',
            'a' => 4,
            'g' => 5,
        );

        $objects = new Objects($data1);
        $this->assertSame(
            array_diff_key($data1, $data2, $data3),
            $objects->diffK(new Objects($data2), new Objects($data3))->toArray()
        );
    }

    /**
     * Tests intersect.
     */
    public function testIntersect()
    {
        $data1 = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $data2 = array(
            1 => 'd',
            2 => 'e',
            'a' => 2,
            'f' => 3,
        );
        $data3 = array(
            1 => 'h',
            3 => '1',
            'a' => 4,
            'g' => 5,
        );

        $objects = new Objects($data1);
        $this->assertSame(
            array_intersect($data1, $data2, $data3),
            $objects->intersect(new Objects($data2), new Objects($data3))->toArray()
        );
    }

    /**
     * Tests intersectA.
     */
    public function testIntersectA()
    {
        $data1 = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $data2 = array(
            1 => 'd',
            2 => 'e',
            'a' => 2,
            'f' => 3,
        );
        $data3 = array(
            1 => 'h',
            3 => '1',
            'a' => 4,
            'g' => 5,
        );

        $objects = new Objects($data1);
        $this->assertSame(
            array_intersect_assoc($data1, $data2, $data3),
            $objects->intersectA(new Objects($data2), new Objects($data3))->toArray()
        );
    }

    /**
     * Tests intersectK.
     */
    public function testIntersectK()
    {
        $data1 = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        $data2 = array(
            1 => 'd',
            2 => 'e',
            'a' => 2,
            'f' => 3,
        );
        $data3 = array(
            1 => 'h',
            3 => '1',
            'a' => 4,
            'g' => 5,
        );

        $objects = new Objects($data1);
        $this->assertSame(
            array_intersect_key($data1, $data2, $data3),
            $objects->intersectK(new Objects($data2), new Objects($data3))->toArray()
        );
    }
}
 