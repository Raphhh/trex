<?php
namespace TRex\Iterator\Iterator;

use TRex\Core\IObjects;

/**
 * Interface IIteratorSorter.
 *
 * @package TRex\Iterator
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IIteratorSorter
{

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
     * @param \TRex\Iterator\Iterator\SortType $type
     * @param callable|int $option
     * @return IObjects
     */
    public function sort(SortType $type = null, $option = SORT_NATURAL);

    /**
     * Reverses the order of the values.
     *
     * @param bool $areKeysPreserved
     * @return IObjects
     */
    public function reverse($areKeysPreserved = true);
}
