<?php
namespace TRex\Serialization\resources;

/**
 * Class RecursiveArray
 * @package TRex\Serialization\resources
 */
class RecursiveArray
{
    /**
     * Recursive objects.
     *
     * @var RecursiveClass
     */
    public $recursiveObjects = array();

    /**
     * Add a new instance to the object.
     *
     * @return RecursiveClass
     */
    public function initRecursion()
    {
        $this->recursiveObjects[0] = $this;

        $this->recursiveObjects[1] = new $this();
        $this->recursiveObjects[1]->recursiveObjects[0] = $this;

        $this->recursiveObjects[2] = $this->recursiveObjects[1];
    }
}
 