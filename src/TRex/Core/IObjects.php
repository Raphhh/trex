<?php
namespace TRex\Core;

use TRex\Iterator\IIterator;
use TRex\Iterator\IIteratorSorter;
use TRex\Iterator\IKeyAccessor;

/**
 * Interface IObjects
 * @package TRex\Core
 */
interface IObjects extends IIterator, \IteratorAggregate, \ArrayAccess, IKeyAccessor, \Countable, IIteratorSorter
{



    /**
     * Gets the value of the associate index.
     * $index can be specified even the keys are associative.
     * If the index is 0, the method will return the first value, ...
     * If the index is -1, the method will return the last value, ...
     *
     * @param int $index
     * @return mixed|null
     */
    public function getByIndex($index);

    /**
     * Gets the first value.
     *
     * @return mixed|null
     */
    public function first();

    /**
     * Gets the last value.
     *
     * @return mixed|null
     */
    public function last();

    /**
     * Merges a series of IObjects.
     * Does not preserve keys.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function merge(IObjects $objects);

    /**
     * Merges a series of IObjects.
     * Preserves keys.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function mergeA(IObjects $objects);

    /**
     * Compares current IObject values with the IObject params.
     * Returns all the values of current IObject that are not present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function diff(IObjects $objects);

    /**
     * Compares current IObject values and keys with the IObject params.
     * Returns all the values of current IObject that are not present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function diffA(IObjects $objects);

    /**
     * Compares current IObject keys with the IObject params.
     * Returns all the values of current IObject that are not present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function diffK(IObjects $objects);

    /**
     * Compares current IObject values with the IObject params.
     * Returns all the values of current IObject that are present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function intersect(IObjects $objects);

    /**
     * Compares current IObject values and keys with the IObject params.
     * Returns all the values of current IObject that are present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function intersectA(IObjects $objects);

    /**
     * Compares current IObject keys with the IObject params.
     * Returns all the values of current IObject that are present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function intersectK(IObjects $objects);

    /**
     * Extracts the sequence of elements.
     * Starts at index $startIndex and stop after $length keys.
     *
     * @param int $startIndex
     * @param int $length
     * @param bool $areKeysPreserved
     * @return IObjects
     */
    public function extract($startIndex, $length = 0, $areKeysPreserved = true);

    /**
     * Executes the callback for every value.
     * Returns an IObjects with the result of each callback call.
     *
     * @param \Closure $callback
     * @return IObjects
     */
    public function each(\Closure $callback);

    /**
     * Executes the callback for every value.
     * Returns an IObjects with the value of witch callback has return true.
     * If no callback is passed, filters on the value itself.
     *
     * @param \Closure $callback
     * @return IObjects
     */
    public function filter(\Closure $callback = null);
}
