<?php
namespace TRex\Core;

use TRex\Iterator\IIterator;
use TRex\Iterator\IKeyAccessor;

/**
 * Interface IObjects
 * @package TRex\Core
 */
interface IObjects extends IIterator, \IteratorAggregate, \ArrayAccess, IKeyAccessor, \Countable
{

    /**
     * Sort type by value.
     * Sort const.
     */
    const VALUE_SORT_TYPE = 'sort';

    /**
     * Sort type by key.
     * Sort const.
     */
    const KEY_SORT_TYPE = 'ksort';

    /**
     * Sort type in an associative way.
     * Sort const.
     */
    const ASSOCIATIVE_SORT_TYPE = 'asort';

    /**
     * Reindex the key numerically.
     * Returns an IObjects with the same values but indexed keys.
     *
     * @return IObjects
     */
    public function reindex();

    /**
     * Sorts values.
     * For more info on sort, see PHP documentation.
     * Returns an IObjects with sorted values.
     * $type describes the type of sorting. (value/key/associative)
     * $option is a PHP sort option or a callback.
     *
     * @param string $type
     * @param int|callable $option
     * @return IObjects
     */
    public function sort($type = self::ASSOCIATIVE_SORT_TYPE, $option = SORT_NATURAL);

    /**
     * Reverses the order of the values.
     *
     * @param bool $areKeysPreserved
     * @return IObjects
     */
    public function reverse($areKeysPreserved = true);

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
