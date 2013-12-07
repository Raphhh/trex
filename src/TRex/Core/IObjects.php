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
     * Reindex the key numerically.
     * Returns an IObjects with the same values but indexed keys.
     *
     * @return IObjects
     */
    public function reindex();

    /**
     * Merges a series of IObjects.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function merge(IObjects $objects);

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
