<?php
namespace TRex\Core;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use TRex\Core\Objects\IComposite;
use TRex\Core\Objects\IObjectsComparator;
use TRex\Core\Objects\IObjectsModifier;
use TRex\Core\Objects\IObjectsSearcher;
use TRex\Iterator\IIterator;
use TRex\Iterator\IKeyAccessor;
use TRex\Iterator\Iterator\IIteratorSorter;

/**
 * IObjects is a oriented object array.
 * This handles a list like an object.
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IObjects extends
    IIterator,
    IteratorAggregate,
    ArrayAccess,
    IKeyAccessor,
    Countable,
    IIteratorSorter,
    IObjectsComparator,
    IObjectsModifier,
    IObjectsSearcher,
    IComposite
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
     * Adds values at the beginning of the list.
     *
     * @param mixed $value
     */
    public function addFirst($value /*, ...*/);

    /**
     * Adds values at the end of the list.
     *
     * @param mixed $value
     */
    public function addLast($value /*, ...*/);

    /**
     * Removes first value of the list.
     */
    public function removeFirst();

    /**
     * Removes last value of the list.
     */
    public function removeLast();
}
