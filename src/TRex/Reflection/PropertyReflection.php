<?php
namespace TRex\Reflection;

/**
 * Class PropertyReflection.
 *
 * @package TRex\Reflection
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 * @method \ReflectionProperty getReflector()
 */
class PropertyReflection extends AttributeReflection
{

    /**
     * Instantiates a new PropertyReflection from a PHP reflector.
     *
     * @param \ReflectionProperty
     * @return PropertyReflection
     */
    public static function instantiate(\ReflectionProperty $reflectedProperty)
    {
        $className = get_called_class();
        return new $className($reflectedProperty->getDeclaringClass()->getName(), $reflectedProperty->getName());
    }

    /**
     * Extracts the value of the property of an object.
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

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    protected function getTypeDocTag()
    {
        return 'var';
    }
}
