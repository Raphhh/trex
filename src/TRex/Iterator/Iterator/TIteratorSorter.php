<?php
namespace TRex\Iterator\Iterator;

use TRex\Iterator\IIterator;

/**
 * Class TIteratorSorter
 * Implements IIteratorSorter.
 *
 * @package TRex\Iterator
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
trait TIteratorSorter
{

    /**
     * Needs IIterator.
     *
     * @return IIterator
     */
    abstract public function getIterator();

    /**
     * See IIteratorSorter.
     *
     * @return self
     */
    public function reindex()
    {
        return new $this(array_values($this->getIterator()->toArray()));
    }

    /**
     * See IIteratorSorter.
     *
     * @param \TRex\Iterator\Iterator\SortType $type
     * @param callable|int $option
     * @return self
     */
    public function sort(SortType $type = null, $option = SORT_NATURAL)
    {
        if (!$type) {
            $type = new SortType(SortType::ASSOCIATIVE_SORT_TYPE);
        }
        $sort = $type->getValue(is_callable($option));

        $values = $this->getIterator()->toArray();
        $sort($values, $option);
        return new $this($values);
    }

    /**
     * See IIteratorSorter.
     *
     * @param bool $areKeysPreserved
     * @return self
     */
    public function reverse($areKeysPreserved = true)
    {
        return new $this(array_reverse($this->getIterator()->toArray(), $areKeysPreserved));
    }
}
