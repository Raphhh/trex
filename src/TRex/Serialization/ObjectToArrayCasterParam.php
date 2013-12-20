<?php
namespace TRex\Serialization;

/**
 * Class ObjectToArrayCasterParam
 * @package TRex\Serialization
 */
class ObjectToArrayCasterParam
{


    /**
     * Indicate if conversion also applies to objects in the properties and to values of arrays.
     *
     * @var bool
     */
    private $isRecursive;

    /**
     * @param bool $isRecursive
     */
    public function __construct($isRecursive)
    {
        $this->setIsRecursive($isRecursive);
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
 