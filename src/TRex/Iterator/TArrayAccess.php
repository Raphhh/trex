<?php
namespace TRex\Iterator;

/**
 * Implements \ArrayAccess.
 *
 * @package TRex\Iterator
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
trait TArrayAccess
{

    /**
     * Needs IIterator.
     *
     * @return IIterator
     */
    abstract public function getIterator();

    /**
     * See \ArrayAccess doc.
     *
     * @internal
     */
    public function offsetExists($offset)
    {
        return $this->getIterator()->exist($offset);
    }

    /**
     * See \ArrayAccess doc.
     *
     * @internal
     */
    public function offsetGet($offset)
    {
        return $this->getIterator()->get($offset);
    }

    /**
     * See \ArrayAccess doc.
     *
     * @internal
     */
    public function offsetSet($offset, $value)
    {
        $this->getIterator()->addAt($offset, $value);
    }

    /**
     * See \ArrayAccess doc.
     *
     * @internal
     */
    public function offsetUnset($offset)
    {
        $this->getIterator()->removeAt($offset);
    }
}
