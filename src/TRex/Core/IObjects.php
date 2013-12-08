<?php
namespace TRex\Core;

use TRex\Iterator\IIterator;
use TRex\Iterator\IIteratorSorter;
use TRex\Iterator\IKeyAccessor;

/**
 * Interface IObjects
 * @package TRex\Core
 */
interface IObjects extends
    IIterator,
    \IteratorAggregate,
    \ArrayAccess,
    IKeyAccessor,
    \Countable,
    IIteratorSorter,
    IObjectsComparator,
    IObjectsModifier
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
}
