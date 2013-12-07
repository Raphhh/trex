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
     * Calls the closure in binding the objects context.
     *
     * @param \Closure $closure
     * @param mixed $value
     * @param mixed $key
     * @return mixed
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
