<?php
namespace TRex\Reflection;

/**
 * Class PropertyReflection.
 *
 * @package TRex\Reflection
 * @transient
 * @method \ReflectionProperty getReflector()
 */
class PropertyReflection extends AttributeReflection
{

    /**
     * Extract the value of the property of an object.
     *
     * @param object $object
     * @param bool $isAccessible
     * @return mixed
     */
    public function getValue($object, $isAccessible = true)
    {
        $this->getReflector()->setAccessible($isAccessible);
        return $this->getReflector()->getValue($object);
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    protected function getReflectorClassName()
    {
        return '\ReflectionProperty';
    }
}
