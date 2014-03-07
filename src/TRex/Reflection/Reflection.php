<?php
namespace TRex\Reflection;

use TRex\Annotation\AnnotationParser;
use TRex\Annotation\Annotations;
use TRex\Core\Object;

/**
 * Class Reflection.
 * Abstract main parent class of reflection.
 *
 * @package TRex\Reflection
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 */
abstract class Reflection extends Object
{
    /**
     * Contains the reflection class of PHP use for the different kind of reflection.
     *
     * @var \Reflector //typing imprecise, due to the architecture of PHP
     */
    private $reflector;

    /**
     * @var Annotations
     */
    private $annotations;

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
     * Getter of $reflector.
     *
     * @return \ReflectionClass|\ReflectionProperty|\ReflectionMethod
     */
    public function getReflector()
    {
        return $this->reflector;
    }

    /**
     * Returns the name of the reflected object, class, property or method.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getReflector()->getName();
    }

    /**
     * Returns the comment annotations of the attributes.
     *
     * @return Annotations
     */
    public function getAnnotations()
    {
        if (null === $this->annotations) {
            $this->setAnnotations($this->buildAnnotations());
        }
        return $this->annotations;
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
     * Setter of $reflector.
     *
     * @param \Reflector $reflector
     */
    private function setReflector(\Reflector $reflector)
    {
        $this->reflector = $reflector;
    }

    /**
     * @return Annotations
     */
    private function buildAnnotations()
    {
        $annotationParser = new AnnotationParser();
        return $annotationParser->getAnnotations($this->getReflector()->getDocComment());
    }

    /**
     * Setter of $annotations
     *
     * @param Annotations $annotations
     */
    private function setAnnotations(Annotations $annotations)
    {
        $this->annotations = $annotations;
    }
}
