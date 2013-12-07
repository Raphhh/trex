<?php
namespace TRex\Core;

use TRex\Iterator\IObjectsIterator;
use TRex\Iterator\IteratorAdapter;
use TRex\Iterator\TArrayAccess;
use TRex\Iterator\TIterator;
use TRex\Iterator\TKeyAccessor;

/**
 * Class Objects
 * @package TRex\Core
 * @transient
 */
class Objects extends Object implements IObjects
{

    use TIterator;
    use TArrayAccess;
    use TKeyAccessor;

    /**
     * @var IObjectsIterator
     */
    private $iterator;

    /**
     * Constructor.
     *
     * @param array $data
     * @todo can accept a json!
     */
    public function __construct(array $data = array())
    {
        $this->setIterator(new IteratorAdapter(new \ArrayIterator($data)));
    }

    /**
     * Getter of $iterator.
     *
     * @return IObjectsIterator
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * Setter of $iterator.
     *
     * @param IObjectsIterator $iterator
     */
    public function setIterator(IObjectsIterator $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * {@inheritDoc}
     *
     * @return Objects
     */
    public function reindex()
    {
        return new $this(array_values($this->toArray()));
    }

    /**
     * {@inheritDoc}
     *
     * @param string $type
     * @param callable|int $option
     * @return Objects
     */
    public function sort($type = self::ASSOCIATIVE_SORT_TYPE, $option = SORT_NATURAL)
    {
        if (is_callable($option)) {
            $type = 'u' . $type;
        }
        $values = $this->toArray();
        $type($values, $option);
        return new $this($values);
    }

    /**
     * {@inheritDoc}
     *
     * @param bool $areKeysPreserved
     * @return Objects
     */
    public function reverse($areKeysPreserved = true)
    {
        return new $this(array_reverse($this->toArray(), $areKeysPreserved));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function merge(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_merge', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function mergeA(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_replace', array_reverse($this->unShiftTo(func_get_args(), $this)));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function diff(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_diff', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function diffA(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_diff_assoc', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function diffK(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_diff_key', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function intersect(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_intersect', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function intersectA(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_intersect_assoc', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function intersectK(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_intersect_key', $this->unShiftTo(func_get_args(), $this));
    }

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
            $length = $this->count();
        }
        return new $this(array_slice($this->toArray(), $startIndex, $length, $areKeysPreserved));
    }

    /**
     * {@inheritDoc}
     *
     * @param \Closure $callback
     * @return Objects
     */
    public function each(\Closure $callback)
    {
        $result = new $this();
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
        $result = new $this();
        foreach ($this as $key => $value) {
            if ($this->invokeClosure($callback, $value, $key)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * Calls a php native function with $objectsList as args.
     * Returns a new instance of Object as result.
     *
     * @param string $functionName
     * @param array $objectsList
     * @return Objects
     */
    private function apply($functionName, array $objectsList)
    {
        return new $this(call_user_func_array($functionName, $this->parseObjectsListToArray($objectsList)));
    }

    /**
     * Transforms a list of IObjects in an simple array.
     *
     * @param array $objectsList
     * @return array
     */
    private function parseObjectsListToArray(array $objectsList)
    {
        return array_map(
            function (IObjects $objects) {
                return $objects->toArray();
            },
            $objectsList
        );
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

    /**
     * Unshifts $value to $array.
     *
     * @param array $array
     * @param mixed $value
     * @return array
     */
    private function unShiftTo(array $array, $value)
    {
        array_unshift($array, $value);
        return $array;
    }

    /**
     * Pushes $value to $array.
     *
     * @param array $array
     * @param mixed $value
     * @return array
     */
    private function pushTo(array $array, $value)
    {
        array_push($array, $value);
        return $array;
    }
}
