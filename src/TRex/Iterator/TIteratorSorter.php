<?php
namespace TRex\Iterator;

use TRex\Core\Objects;

/**
 * Class TIteratorSorter
 * Implements IIteratorSorter.
 * @package TRex\Iterator
 */
trait TIteratorSorter {

    /**
     * Needs IIterator.
     *
     * @return IIterator
     */
    abstract public function getIterator();

    /**
     * See IIteratorSorter.
     *
     * @return Objects
     */
    public function reindex()
    {
        return new Objects(array_values($this->getIterator()->toArray()));
    }

    /**
     * See IIteratorSorter.
     *
     * @param \TRex\Iterator\SortType $type
     * @param callable|int $option
     * @return Objects
     */
    public function sort(SortType $type = null, $option = SORT_NATURAL)
    {
        if (!$type) {
            $type = new SortType(SortType::ASSOCIATIVE_SORT_TYPE);
        }
        $sort = $type->getValue(is_callable($option));

        $values = $this->getIterator()->toArray();
        $sort($values, $option);
        return new Objects($values);
    }

    /**
     * See IIteratorSorter.
     *
     * @param bool $areKeysPreserved
     * @return Objects
     */
    public function reverse($areKeysPreserved = true)
    {
        return new Objects(array_reverse($this->getIterator()->toArray(), $areKeysPreserved));
    }
}
