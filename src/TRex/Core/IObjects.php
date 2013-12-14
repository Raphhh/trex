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
     * Const for has and search mode.
     * Search value in a non-strict way.
     */
    const NON_STRICT_SEARCH_MODE = 'non-strict';

    /**
     * Const for has and search mode.
     * Search value in a strict way.
     */
    const STRICT_SEARCH_MODE = 'strict';

    /**
     * Const for has and search mode.
     * Search value with a regex.
     */
    const REGEX_SEARCH_MODE = 'regex';

    /**
     * Indicates if the value is present.
     *
     * @param string $value
     * @param string $searchMode
     * @return bool
     */
    public function has($value, $searchMode = self::STRICT_SEARCH_MODE);

    /**
     * Searches the keys for the value.
     *
     * @param string $value
     * @param string $searchMode
     * @return array
     */
    public function search($value, $searchMode = self::STRICT_SEARCH_MODE);

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
