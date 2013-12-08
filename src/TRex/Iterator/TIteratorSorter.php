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
     * @param string $type
     * @param callable|int $option
     * @return Objects
     */
    public function sort($type = IIteratorSorter::ASSOCIATIVE_SORT_TYPE, $option = SORT_NATURAL)
    {
        if (is_callable($option)) {
            $type = 'u' . $type;
        }
        $values = $this->getIterator()->toArray();
        $type($values, $option);
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
