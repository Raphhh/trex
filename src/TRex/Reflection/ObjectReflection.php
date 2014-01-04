<?php
namespace TRex\Reflection;

/**
 * Class ObjectReflection
 *
 * @package TRex\Reflection
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
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
     * Accepts only an instance of a class.
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
     * Gets the current reflected object.
     *
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Sets the current reflected object.
     *
     * @param object $object
     */
    private function setObject($object)
    {
        $this->object = $object;
    }
}
