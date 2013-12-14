<?php
namespace TRex\Iterator;

use TRex\Core\IObjects;

/**
 * Interface IIteratorSorter
 * @package TRex\Iterator
 */
interface IIteratorSorter {

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
}
