<?php
namespace TRex\Iterator;

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
     * @param \TRex\Iterator\SortType $type
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

    function orderBy(array $orders)
    {
        $values = $this->getIterator()->toArray();
        usort($values, $this->getOrderByClosure($orders));
        return new $this($values);
    }

    private function getOrderByClosure(array $orders)
    {
        return \Closure::bind(
            function ($refData, $compData) use ($orders) {
                return $this->inspectOrdering($refData, $compData, $orders);
            },
            $this,
            get_class($this)
        );
    }

    private function inspectOrdering($refData, $compData, array $orders)
    {
        foreach ($orders as $key => $order) {
            if ($this->getValue($refData, $key) !== $this->getValue($compData, $key)) {
                if ($this->getValue($refData, $key) < $this->getValue($compData, $key)) {
                    return $order * (-1);
                }
                return $order;
            }
        }
        return 0;
    }

    private function getValue($data, $key)
    {
        if (is_object($data)) {
            return $data->{'get' . $key}();
        }
        if (is_array($data)) {
            return $data[$key];
        }
        throw new \LogicException(sprintf('Values must be array or object. %s received.', gettype($data)));
    }
}
