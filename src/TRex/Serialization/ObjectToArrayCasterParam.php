<?php
namespace TRex\Serialization;

/**
 * Class ObjectToArrayCasterParam
 * @package TRex\Serialization
 */
class ObjectToArrayCasterParam
{

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
     * @param bool $isFullName
     * @param bool $isRecursive
     */
    public function __construct($isFullName, $isRecursive)
    {
        $this->setIsFullName($isFullName);
        $this->setIsRecursive($isRecursive);
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
 