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
     * {@inheritDoc}
     *
     * @return string
     */
    protected function getReflectorClassName()
    {
        return '\ReflectionMethod';
    }
}
 