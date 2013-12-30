<?php
namespace TRex\Iterator;

/**
 * Interface IIterator
 * @package TRex\Iterator
 */
interface IIterator
{

    /**
     * Checks if the offset exists.
     *
     * @param mixed $key
     * @return bool
     */
    public function exist($key);

    /**
     * Gets the value from the provided offset.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key);

    /**
     * Gets the current array key.
     *
     * @return mixed
     */
    public function key();

    /**
     * Gets the current array entry.
     *
     * @return mixed
     */
    public function current();

    /**
     * Sets the iterator to the next entry.
     */
    public function next();

    /**
     * Rewinds the iterator to the beginning.
     */
    public function rewind();

    /**
     * Sets the iterator to a specified offset.
     *
     * @param $index
     */
    public function seek($index);

    /**
     * Checks if the array contains any more entries.
     *
     * @return bool
     */
    public function valid();

    /**
     * Sets a value for a specified offset.
     *
     * @param $key
     * @param $value
     */
    public function addAt($key, $value);

    /**
     * Unsets a value for an offset.
     *
     * @param $key
     */
    public function removeAt($key);

    /**
     * Gets the number of elements in the array, or the number of public properties in the object.
     *
     * @return int
     */
    public function count();

    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function toArray();
}
