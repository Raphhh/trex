<?php
namespace TRex\Core;

use TRex\Iterator\IObjectsIterator;
use TRex\Iterator\IteratorAdapter;
use TRex\Iterator\TArrayAccess;
use TRex\Iterator\TIterator;
use TRex\Iterator\TIteratorSorter;
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
    use TIteratorSorter;
    use TObjectsComparator;
    use TObjectsModifier;

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
     * @param string $value
     * @param string $searchMode
     * @return bool
     */
    public function has($value, $searchMode = self::STRICT_SEARCH_MODE)
    {
        if ($searchMode === self::REGEX_SEARCH_MODE) {
            return (bool)$this->search($value, $searchMode);
        }
        return in_array($value, $this->toArray(), $searchMode === self::STRICT_SEARCH_MODE);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $value
     * @param string $searchMode
     * @return array
     */
    public function search($value, $searchMode = self::STRICT_SEARCH_MODE)
    {
        if ($searchMode === self::REGEX_SEARCH_MODE) {
            return array_keys(preg_grep($value, $this->toArray()));
        }
        return array_keys($this->toArray(), $value, $searchMode === self::STRICT_SEARCH_MODE);
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
}
