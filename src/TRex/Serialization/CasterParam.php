<?php
namespace TRex\Serialization;

/**
 * Class CasterParam
 * @package TRex\Serialization
 */
class CasterParam 
{

    /**
     * Filter of visibility
     *
     * @var int
     */
    private $filter;

    /**
     * Indicate the kind of keys.
     * If is true, keys will be composed by full name of property (class name + property name)
     *
     * @var bool
     */
    private $isFullName;

    /**
     * Indicate if conversion also applies to objects in the properties and to values of arrays.
     *
     * @var bool
     */
    private $isRecursive;

    /**
     * @param int $filter
     * @param bool $isFullName
     * @param bool $isRecursive
     */
    public function __construct($filter, $isFullName, $isRecursive)
    {
        $this->setFilter($filter);
        $this->setIsFullName($isFullName);
        $this->setIsRecursive($isRecursive);
    }

    /**
     * Setter of $filter.
     *
     * @param int $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Getter of $filter.
     *
     * @return int
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Setter of $isFullName.
     *
     * @param boolean $isFullName
     */
    public function setIsFullName($isFullName)
    {
        $this->isFullName = $isFullName;
    }

    /**
     * Getter of $isFullName.
     *
     * @return boolean
     */
    public function isFullName()
    {
        return $this->isFullName;
    }

    /**
     * Setter of $isRecursive.
     *
     * @param boolean $isRecursive
     */
    public function setIsRecursive($isRecursive)
    {
        $this->isRecursive = $isRecursive;
    }

    /**
     * Getter of $isRecursive.
     *
     * @return boolean
     */
    public function isRecursive()
    {
        return $this->isRecursive;
    }
}
 