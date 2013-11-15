<?php
namespace TRex\Reflection;

/**
 * Class ObjectReflection
 *
 * @package TRex\Reflection
 * @transient
 */
class ObjectReflection extends ClassReflection
{
    /**
     * Current reflected object.
     *
     * @var object
     */
    private $object;

    /*
     * Accept only an instance of a class.
     * This instance can be recovered with self::getObject();
     *
     * var object $object
     */
    public function __construct($object)
    {
        $this->setObject($object);
        parent::__construct(get_class($object));
    }

    /**
     * Getter of $object.
     *
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Setter of $object.
     *
     * @param object $object
     */
    private function setObject($object)
    {
        $this->object = $object;
    }
}
 