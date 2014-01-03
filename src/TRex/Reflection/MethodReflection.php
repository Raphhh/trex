<?php
namespace TRex\Reflection;

/**
 * Class MethodReflection.
 *
 * @package TRex\Reflection
 * @transient
 * @method \ReflectionMethod getReflector()
 */
class MethodReflection extends AttributeReflection
{

    /**
     * Instantiate a new MethodReflection from a PHP reflector.
     *
     * @param \ReflectionMethod
     * @return MethodReflection
     */
    public static function instantiate(\ReflectionMethod $reflectedMethod)
    {
        $className = get_called_class();
        return new $className($reflectedMethod->getDeclaringClass()->getName(), $reflectedMethod->getName());
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    protected function getReflectorClassName()
    {
        return '\ReflectionMethod';
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    protected function getTypeDocTag()
    {
        return 'return';
    }
}
