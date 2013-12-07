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
     * Executes the callback for every value.
     * Returns an IObjects with the result of each callback call.
     *
     * @param callable $callback
     * @return IObjects
     */
    public function each(\Closure $callback);
}
