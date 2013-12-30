<?php
namespace TRex\Serialization\resources;

/**
 * Class RecursiveClass
 * @package TRex\Serialization\resources
 */
class RecursiveClass
{

    /**
     * Recursive object.
     *
     * @var RecursiveClass
     */
    public $recursiveObject0;

    /**
     * Recursive object.
     *
     * @var RecursiveClass
     */
    public $recursiveObject1;

    /**
     * Recursive object.
     *
     * @var RecursiveClass
     */
    public $recursiveObject2;

    /**
     * Add a new instance to the object.
     *
     * @return RecursiveClass
     */
    public function initRecursion()
    {
        $this->recursiveObject0 = $this;

        $this->recursiveObject1 = new $this();
        $this->recursiveObject1->recursiveObject0 = $this;

        $this->recursiveObject2 = $this->recursiveObject1;
    }
}
