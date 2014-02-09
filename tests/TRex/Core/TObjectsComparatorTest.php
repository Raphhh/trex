<?php
namespace TRex\Core;

/**
 * Class TObjectsComparatorTest
 * Calss test for TObjectsComparator
 * @package TRex\Core
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

        $objects = new resources\Foos($data1);
        $result = $objects->merge(new Objects($data2), new Objects($data3));

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(
            array_merge($data1, $data2, $data3),
            $result->toArray()
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

        $objects = new resources\Foos($data1);
        $result = $objects->mergeA(new Objects($data2), new Objects($data3));

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(
            array_replace($data3, $data2, $data1),
            $result->toArray()
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

        $objects = new resources\Foos($data1);
        $result = $objects->diff(new Objects($data2), new Objects($data3));

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(
            array_diff($data1, $data2, $data3),
            $result->toArray()
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

        $objects = new resources\Foos($data1);
        $result = $objects->diffA(new Objects($data2), new Objects($data3));

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(
            array_diff_assoc($data1, $data2, $data3),
            $result->toArray()
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

        $objects = new resources\Foos($data1);
        $result = $objects->diffK(new Objects($data2), new Objects($data3));

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(
            array_diff_key($data1, $data2, $data3),
            $result->toArray()
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

        $objects = new resources\Foos($data1);
        $result = $objects->intersect(new Objects($data2), new Objects($data3));

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(
            array_intersect($data1, $data2, $data3),
            $result->toArray()
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

        $objects = new resources\Foos($data1);
        $result = $objects->intersectA(new Objects($data2), new Objects($data3));

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(
            array_intersect_assoc($data1, $data2, $data3),
            $result->toArray()
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

        $objects = new resources\Foos($data1);
        $result = $objects->intersectK(new Objects($data2), new Objects($data3));

        $this->assertInstanceOf(get_class($objects), $result);
        $this->assertSame(
            array_intersect_key($data1, $data2, $data3),
            $result->toArray()
        );
    }
}
