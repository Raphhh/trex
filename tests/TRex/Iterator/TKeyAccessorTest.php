<?php
namespace TRex\Iterator;

/**
 * Class TKeyAccessorTest
 * test class for TKeyAccessor.
 * @package TRex\Iterator
 */
class TKeyAccessorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests getKeys.
     */
    public function testGetKeys()
    {
        $this->assertSame(array(1, 0, 'a', 'b'), $this->getTKeyAccessor()->getKeys());
    }

    /**
     * Tests getKey.
     */
    public function testGetKey()
    {
        $this->assertSame(0, $this->getTKeyAccessor()->getKey(1));
        $this->assertSame('a', $this->getTKeyAccessor()->getKey(-2));
        $this->assertNull($this->getTKeyAccessor()->getKey(5));
    }

    /**
     * Tests getFirstKey.
     */
    public function testGetFirstKey()
    {
        $this->assertSame(1, $this->getTKeyAccessor()->getFirstKey());
    }

    /**
     * Tests getLastKey.
     */
    public function testGetLastKey()
    {
        $this->assertSame('b', $this->getTKeyAccessor()->getLastKey());
    }

    /***
     * Formats a TKeyAccessor mock.
     * @return TKeyAccessor
     */
    private function getTKeyAccessor()
    {
        $tKeyAccessor = $this->getMockBuilder('TRex\Iterator\resources\KeyAccessor')
            ->setMethods(array('getIterator'))
            ->getMock();

        $tKeyAccessor->expects($this->any())
            ->method('getIterator')
            ->will($this->returnValue($this->getIterator()));
        return $tKeyAccessor;
    }

    /**
     * Formats basic data for iterator.
     *
     * @return IteratorAdapter
     */
    private function getIterator()
    {
        $data = array(
            1 => 'a',
            0 => 'b',
            'a' => 1,
            'b' => 0,
        );
        return new IteratorAdapter(new \ArrayIterator($data));
    }
}
