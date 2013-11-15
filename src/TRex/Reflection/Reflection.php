<?php
namespace TRex\Reflection;

use TRex\Core\Object;

/**
 * Class Reflection
 * Abstract main parent class of reflection
 * @package TRex\Reflection
 * @transient
 */
abstract class Reflection extends Object
{
    /**
     * Contain the reflection class of PHP use for the different kind of reflection.
     *
     * @var \Reflector //typing imprecise, due to the architecture of PHP
     */
    private $reflector;

    /**
     * Reflector must be added at the instantiation of the object,
     * and must be a PHP reflection class chosen according to the king of reflection.
     *
     * @param \Reflector $reflector
     */
    public function __construct(\Reflector $reflector)
    {
        $this->setReflector($reflector);
    }

    /**
     * Return the name of the reflected object, class, property or method.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getReflector()->getName();
    }

    /**
     * Transient is a comment tag (@transient) added to a class, a property or a method.
     * This tag is use to not convert the value.
     *
     * @return bool
     */
    public function isTransient()
    {
        return strpos(strval($this->getReflector()->getDocComment()), '@transient') !== false;
    }

    /**
     * Getter of $reflector.
     *
     * @return \ReflectionClass|\ReflectionProperty|\ReflectionMethod
     */
    protected function getReflector()
    {
        return $this->reflector;
    }

    /**
     * Setter of $reflector.
     *
     * @param \Reflector $reflector
     */
    private function setReflector(\Reflector $reflector)
    {
        $this->reflector = $reflector;
    }
}
