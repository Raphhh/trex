<?php
namespace TRex\Iterator;

use TRex\Core\Object;

/**
 * Adapts \ArrayIterator to TRex\Iterator IObjectsIterator.
 *
 * @package TRex\Iterator
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 * @internal
 */
class IteratorAdapter extends Object implements IObjectsIterator
{

    /**
     * Current adapted ArrayIterator.
     *
     * @var \ArrayIterator
     */
    private $arrayIterator;

    /**
     * Constructor.
     *
     * @param \ArrayIterator $arrayIterator
     */
    public function __construct(\ArrayIterator $arrayIterator)
    {
        $this->setArrayIterator($arrayIterator);
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $key
     * @return bool
     */
    public function exist($key)
    {
        return $this->getArrayIterator()->offsetExists($key);
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->getArrayIterator()->offsetGet($key);
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function addAt($key, $value)
    {
        $this->getArrayIterator()->offsetSet($key, $value);
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $key
     */
    public function removeAt($key)
    {
        $this->getArrayIterator()->offsetUnset($key);
    }

    /**
     * {@inheritDoc}
     *
     * @return mixed
     */
    public function key()
    {
        return $this->getArrayIterator()->key();
    }

    /**
     * {@inheritDoc}
     *
     * @return mixed
     */
    public function current()
    {
        return $this->getArrayIterator()->current();
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->getArrayIterator()->next();
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->getArrayIterator()->rewind();
    }

    /**
     * {@inheritDoc}
     *
     * @param $index
     */
    public function seek($index)
    {
        $this->getArrayIterator()->seek($index);
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function valid()
    {
        return $this->getArrayIterator()->valid();
    }

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function count()
    {
        return $this->getArrayIterator()->count();
    }

    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getArrayIterator()->getArrayCopy();
    }

    /**
     * Setter of $arrayIterator
     *
     * @param \ArrayIterator $arrayIterator
     */
    private function setArrayIterator(\ArrayIterator $arrayIterator)
    {
        $this->arrayIterator = $arrayIterator;
    }

    /**
     * Getter of $arrayIterator
     *
     * @return \ArrayIterator
     */
    private function getArrayIterator()
    {
        return $this->arrayIterator;
    }
}
