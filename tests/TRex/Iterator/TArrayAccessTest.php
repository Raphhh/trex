<?php
namespace TRex\Iterator;

/**
 * Class TArrayAccessTest
 * test class for TArrayAccess.
 * @package TRex\Iterator
 */
class TArrayAccessTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests offsetExists.
     */
    public function testOffsetExists()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('exist'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('exist')
            ->will($this->returnArgument(0));

        $this->assertSame('test', $this->getTIterator($iterator)->offsetExists('test'));
    }

    /**
     * Tests offsetExists.
     */
    public function offsetGet()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('get')
            ->will($this->returnArgument(0));

        $this->assertSame('test', $this->getTIterator($iterator)->offsetGet('test'));
    }

    /**
     * Tests offsetSet.
     */
    public function testOffsetSet()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('addAt'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('addAt')
            ->with($this->equalTo('key'), $this->equalTo('value'));

        $this->getTIterator($iterator)->offsetSet('key', 'value');
    }

    /**
     * Tests offsetUnset.
     */
    public function testOffsetUnset()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('removeAt'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('removeAt')
            ->with($this->equalTo('key'));

        $this->getTIterator($iterator)->offsetUnset('key');
    }

    /**
     * Formats a TArrayAccess mock.
     *
     * @param IIterator $iterator
     * @return TArrayAccess
     */
    private function getTIterator(IIterator $iterator)
    {
        $tIterator = $this->getMockBuilder('TRex\Iterator\resources\ArrayAccess')
            ->setMethods(array('getIterator'))
            ->getMock();

        $tIterator->expects($this->any())
            ->method('getIterator')
            ->will($this->returnValue($iterator));
        return $tIterator;
    }
}
