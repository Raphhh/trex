<?php
namespace TRex\Iterator;

/**
 * Class IteratorAdapterTest
 * @package TRex\Iterator
 */
class IteratorAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests exist.
     */
    public function testExist()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('offsetExists'));
        $arrayIterator->expects($this->once())
            ->method('offsetExists')
            ->will($this->returnArgument(0));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $this->assertSame('key', $iteratorAdapter->exist('key'));

    }

    /**
     * Tests get.
     */
    public function testGet()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('offsetGet'));
        $arrayIterator->expects($this->once())
            ->method('offsetGet')
            ->will($this->returnArgument(0));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $this->assertSame('key', $iteratorAdapter->get('key'));
    }

    /**
     * Tests addAt.
     */
    public function testAddAt()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('offsetSet'));
        $arrayIterator->expects($this->once())
            ->method('offsetSet')
            ->with($this->equalTo('key'), $this->equalTo('value'));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $iteratorAdapter->addAt('key', 'value');
    }

    /**
     * Tests removeAt.
     */
    public function testRemoveAt()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('offsetUnset'));
        $arrayIterator->expects($this->once())
            ->method('offsetUnset')
            ->with($this->equalTo('key'));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $iteratorAdapter->removeAt('key');
    }

    /**
     * Tests key.
     */
    public function testKey()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('key'));
        $arrayIterator->expects($this->once())
            ->method('key')
            ->will($this->returnValue('key'));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $this->assertSame('key', $iteratorAdapter->key());
    }

    /**
     * Tests current.
     */
    public function testCurrent()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('current'));
        $arrayIterator->expects($this->once())
            ->method('current')
            ->will($this->returnValue('value'));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $this->assertSame('value', $iteratorAdapter->current());
    }

    /**
     * Tests next.
     */
    public function testNext()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('next'));
        $arrayIterator->expects($this->once())
            ->method('next');

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $iteratorAdapter->next();
    }

    /**
     * Tests rewind.
     */
    public function testRewind()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('rewind'));
        $arrayIterator->expects($this->once())
            ->method('rewind');

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $iteratorAdapter->rewind();
    }

    /**
     * Tests seek.
     */
    public function testSeek()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('seek'));
        $arrayIterator->expects($this->once())
            ->method('seek')
            ->with($this->equalTo('key'));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $iteratorAdapter->seek('key');
    }

    /**
     * Tests valid.
     */
    public function testValid()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('valid'));
        $arrayIterator->expects($this->once())
            ->method('valid')
            ->will($this->returnValue(true));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $this->assertTrue($iteratorAdapter->valid());
    }

    /**
     * Tests count.
     */
    public function testCount()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('count'));
        $arrayIterator->expects($this->once())
            ->method('count')
            ->will($this->returnValue(10));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $this->assertSame(10, $iteratorAdapter->count());
    }

    /**
     * Tests toArray.
     */
    public function testToArray()
    {
        $arrayIterator = $this->getMock('\ArrayIterator', array('getArrayCopy'));
        $arrayIterator->expects($this->once())
            ->method('getArrayCopy')
            ->will($this->returnValue(array(1, 2, 3)));

        $iteratorAdapter = new IteratorAdapter($arrayIterator);
        $this->assertSame(array(1, 2, 3), $iteratorAdapter->toArray());
    }
}
 