<?php
namespace TRex\Iterator;

/**
 * Implements IKeyAccessor.
 *
 * @package TRex\Iterator
 */
trait TKeyAccessor
{

    /**
     * Needs IIterator.
     *
     * @return IIterator
     */
    abstract public function getIterator();


    /**
     * See IKeyAccessor.
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->getIterator()->toArray());
    }

    /**
     * See IKeyAccessor.
     *
     * @param int $index
     * @return mixed|null
     */
    public function getKey($index)
    {
        $index = $this->absKeyIndex(intval($index));
        $keys = $this->getKeys();
        if (isset($keys[$index])) {
            return $keys[$index];
        }
        return null;
    }


    /**
     * See IKeyAccessor.
     *
     * @return mixed|null
     */
    public function getFirstKey()
    {
        return $this->getKey(0);
    }

    /**
     * See IKeyAccessor.
     *
     * @return mixed|null
     */
    public function getLastKey()
    {
        return $this->getKey(-1);
    }

    /**
     * Convert a negative index to a positive one.
     *
     * @param $index
     * @return int
     */
    private function absKeyIndex($index)
    {
        if ($index < 0) {
            return $this->getIterator()->count() + $index;
        }
        return $index;
    }
}
