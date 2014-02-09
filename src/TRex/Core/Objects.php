<?php
namespace TRex\Core;

use TRex\Iterator\IObjectsIterator;
use TRex\Iterator\IteratorAdapter;
use TRex\Iterator\TArrayAccess;
use TRex\Iterator\TIterator;
use TRex\Iterator\TIteratorSorter;
use TRex\Iterator\TKeyAccessor;
use TRex\Serialization\DataToArrayCaster;

/**
 * IObjects is a oriented object array.
 * This handles a list like an object.
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 */
class Objects extends Object implements IObjects
{

    use TIterator;
    use TArrayAccess;
    use TKeyAccessor;
    use TObjectsSearcher;
    use TIteratorSorter;
    use TObjectsComparator;
    use TObjectsModifier;
    use TComposite;

    /**
     * Current iterator.
     *
     * @var IObjectsIterator
     */
    private $iterator;

    /**
     * Constructor.
     *
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        $this->initIterator($data);
    }

    public function __call($methodName, array $args)
    {
        if ($this->getMethod($methodName)) {
            return parent::__call($methodName, $args);
        }
        return $this->invoke($methodName, $args);
    }

    /**
     * Returns the current iterator.
     *
     * @return IObjectsIterator
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * Sets the current Iterator.
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
     * @param int $index
     * @return mixed|null
     */
    public function getByIndex($index)
    {
        $key = $this->getKey($index);
        if (null !== $key) {
            return $this->get($key);
        }
        return null;
    }

    /**
     * {@inheritDoc}
     *
     * @param int $index
     * @return mixed|null
     */
    public function first()
    {
        $key = $this->getFirstKey();
        if (null !== $key) {
            return $this->get($key);
        }
        return null;
    }

    /**
     * {@inheritDoc}
     *
     * @return mixed|null
     */
    public function last()
    {
        $key = $this->getLastKey();
        if (null !== $key) {
            return $this->get($key);
        }
        return null;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $value
     */
    public function addFirst($value /*, ...*/)
    {
        $arrayModified = $this->toArray();
        foreach (func_get_args() as $value) {
            array_unshift($arrayModified, $value);
        }
        $this->initIterator($arrayModified);
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $value
     */
    public function addLast($value /*, ...*/)
    {
        foreach (func_get_args() as $value) {
            $this[] = $value;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function removeFirst()
    {
        $arrayModified = $this->toArray();
        array_shift($arrayModified);
        $this->initIterator($arrayModified);
    }

    /**
     * {@inheritDoc}
     */
    public function removeLast()
    {
        $key = $this->getLastKey();
        if (null !== $key) {
            $this->removeAt($key);
        }
    }

    /**
     * Init $iterator.
     *
     * @param null $data
     */
    private function initIterator($data = null)
    {
        $this->setIterator(new IteratorAdapter(new \ArrayIterator((new DataToArrayCaster())->cast($data))));
    }
}
