<?php
namespace TRex\Core;

use TRex\Iterator\IIterator;

trait TObjectsModifier
{
    /**
     * Needs IIterator.
     *
     * @return IIterator
     */
    abstract public function getIterator();

    /**
     * {@inheritDoc}
     *
     * @param int $startIndex
     * @param int $length
     * @param bool $areKeysPreserved
     * @return IObjects
     */
    public function extract($startIndex, $length = 0, $areKeysPreserved = true)
    {
        if (!$length) {
            $length = $this->getIterator()->count();
        }
        return new Objects(array_slice($this->getIterator()->toArray(), $startIndex, $length, $areKeysPreserved));
    }

    /**
     * {@inheritDoc}
     *
     * @param \Closure $callback
     * @return Objects
     */
    public function each(\Closure $callback)
    {
        $result = new Objects();
        foreach ($this as $key => $object) {
            $result[$key] = $this->invokeClosure($callback, $object, $key);
        }
        return $result;
    }

    /**
     * {@inheritDoc}
     *
     * @param \Closure $callback
     * @return Objects
     */
    public function filter(\Closure $callback = null)
    {
        $callback = $this->formatFilter($callback);
        $result = new Objects();
        foreach ($this as $key => $value) {
            if ($this->invokeClosure($callback, $value, $key)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * Calls the closure in binding the objects context.
     *
     * @param \Closure $closure
     * @param mixed $value
     * @param mixed $key
     * @return Objects
     */
    private function invokeClosure(\Closure $closure, $value, $key)
    {
        if (is_object($value)) {
            $closure = \Closure::bind($closure, $value, get_class($value));
        }
        return $closure($value, $key, $this);
    }

    /**
     * Formats a callback filter.
     * If the filter is null, gets a default filter.
     *
     * @param \Closure $callback
     * @return \Closure
     */
    private function formatFilter(\Closure $callback = null)
    {
        return $callback ? : function ($value) {
            return (bool)$value;
        };
    }
}
