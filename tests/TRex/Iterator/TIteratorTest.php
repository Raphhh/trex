<?php
namespace TRex\Iterator;

/**
 * Class TIteratorTest.
 * test class for TIterator.
 * @package TRex\Iterator
 */
class TIteratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests exist.
     */
    public function testExist()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('exist'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('exist')
            ->will($this->returnArgument(0));

        $this->assertSame('test', $this->getTIterator($iterator)->exist('test'));
    }

    /**
     * Tests get.
     */
    public function testGet()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('get')
            ->will($this->returnArgument(0));

        $this->assertSame('test', $this->getTIterator($iterator)->get('test'));
    }

    /**
     * Tests key.
     */
    public function testKey()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('key'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('key')
            ->will($this->returnValue('test'));

        $this->assertSame('test', $this->getTIterator($iterator)->key());
    }

    /**
     * Tests current.
     */
    public function testCurrent()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('current'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('current')
            ->will($this->returnValue('test'));

        $this->assertSame('test', $this->getTIterator($iterator)->current());
    }

    /**
     * Tests next.
     */
    public function testNext()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('next'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('next')
            ->will($this->returnValue('test'));

        $this->assertSame('test', $this->getTIterator($iterator)->next());
    }

    /**
     * Tests rewind.
     */
    public function testRewind()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('rewind'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('rewind')
            ->will($this->returnValue('test'));

        $this->assertSame('test', $this->getTIterator($iterator)->rewind());
    }

    /**
     * Tests seek.
     */
    public function testSeek()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('seek'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('seek')
            ->with($this->equalTo('test'));

        $this->getTIterator($iterator)->seek('test');
    }

    /**
     * Tests valid.
     */
    public function testValid()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('valid'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('valid')
            ->will($this->returnValue('test'));

        $this->assertSame('test', $this->getTIterator($iterator)->valid());
    }

    /**
     * Tests addAt.
     */
    public function testAddAt()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('addAt'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('addAt')
            ->with($this->equalTo('key'), $this->equalTo('value'));

        $this->getTIterator($iterator)->addAt('key', 'value');
    }

    /**
     * Tests removeAt.
     */
    public function testRemoveAt()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('removeAt'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('removeAt')
            ->with($this->equalTo('key'));

        $this->getTIterator($iterator)->removeAt('key');
    }

    /**
     * Tests count.
     */
    public function testCount()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('count'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('count')
            ->will($this->returnValue('test'));

        $this->assertSame('test', $this->getTIterator($iterator)->count());
    }

    /**
     * Tests toArray.
     */
    public function testToArray()
    {
        $iterator = $this->getMockBuilder('TRex\Iterator\Iterator\IteratorAdapter')
            ->disableOriginalConstructor()
            ->setMethods(array('toArray'))
            ->getMock();
        $iterator->expects($this->any())
            ->method('toArray')
            ->will($this->returnValue('test'));

        $this->assertSame('test', $this->getTIterator($iterator)->toArray());
    }

    /**
     * Formats a TIterator mock.
     *
     * @param IIterator $iterator
     * @return TIterator
     */
    private function getTIterator(IIterator $iterator)
    {
        $tIterator = $this->getMockBuilder('TRex\Iterator\resources\Iterator')
            ->setMethods(array('getIterator'))
            ->getMock();

        $tIterator->expects($this->any())
            ->method('getIterator')
            ->will($this->returnValue($iterator));
        return $tIterator;
    }
}
