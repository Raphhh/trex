<?php
namespace TRex\Reflection;

/**
 * Class ClassReflection
 * Reflected a class (but not an object)
 *
 * @package TRex\Reflection
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 * @method \ReflectionClass getReflector()
 */
class ClassReflection extends Reflection
{
    /*
     * Accepts only the name of the reflected class.
     *
     * var string $className
     */
    public function __construct($className)
    {
        parent::__construct(new \ReflectionClass((string)$className));
    }

    /**
     * Returns the property of the reflected class and all of its parents
     * (This last point is the main difference with the PHP reflection).
     * Filter is the same as \ReflectionProperty of PHP reflection:
     * You can use these constants or use AttributeReflection constants.
     *
     * @param int $filter
     * @return PropertyReflection[]
     */
    public function getReflectionProperties($filter = AttributeReflection::NO_FILTER)
    {
        $result = array();
        foreach ($this->extractProperties($this->getReflector(), $filter) as $key => $reflectedProperty) {
            $result[$key] = PropertyReflection::instantiate($reflectedProperty);
        }
        return $result;
    }

    /**
     *
     * Recursive properties extraction. Returns properties of the $reflectedClass and parents.
     *
     * @param \ReflectionClass $reflectedClass
     * @param int $filter
     * @return \ReflectionProperty[]
     */
    private function extractProperties(\ReflectionClass $reflectedClass, $filter)
    {
        $result = $reflectedClass->getProperties($filter);
        if ($reflectedClass->getParentClass()) {
            $result = array_merge($result, $this->extractProperties($reflectedClass->getParentClass(), $filter));
        }
        return $result;
    }
}
