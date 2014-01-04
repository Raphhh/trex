<?php
namespace TRex\Iterator;

/**
 * Implements IIterator.
 *
 * @package TRex\Iterator
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
trait TIterator
{

    /**
     * Needs IIterator.
     *
     * @return IIterator
     */
    abstract public function getIterator();

    /**
     * See IIterator.
     *
     * @param mixed $key
     * @return bool
     */
    public function exist($key)
    {
        return $this->getIterator()->exist($key);
    }

    /**
     * See IIterator.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->getIterator()->get($key);
    }

    /**
     * See IIterator.
     *
     * @return mixed
     */
    public function key()
    {
        return $this->getIterator()->key();
    }

    /**
     * See IIterator.
     *
     * @return mixed
     */
    public function current()
    {
        return $this->getIterator()->current();
    }

    /**
     * See IIterator.
     *
     * @return mixed
     */
    public function next()
    {
        return $this->getIterator()->next();
    }

    /**
     * See IIterator.
     *
     * @return mixed
     */
    public function rewind()
    {
        return $this->getIterator()->rewind();
    }

    /**
     * See IIterator.
     *
     * @param mixed $index
     */
    public function seek($index)
    {
        $this->getIterator()->seek($index);
    }

    /**
     * See IIterator.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->getIterator()->valid();
    }

    /**
     * See IIterator.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function addAt($key, $value)
    {
        $this->getIterator()->addAt($key, $value);
    }

    /**
     * See IIterator.
     *
     * @param mixed $key
     */
    public function removeAt($key)
    {
        $this->getIterator()->removeAt($key);
    }

    /**
     * See IIterator.
     *
     * @return int
     */
    public function count()
    {
        return $this->getIterator()->count();
    }

    /**
     * See IIterator.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getIterator()->toArray();
    }
}
