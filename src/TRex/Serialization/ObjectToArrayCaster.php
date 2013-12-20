<?php
namespace TRex\Serialization;

use TRex\Core\Object;
use TRex\Reflection\AttributeReflection;
use TRex\Reflection\ObjectReflection;

/**
 * Class ObjectToArrayCaster.
 * Object conversion handler.
 *
 * @package TRex\Serialization
 * @transient
 */
class ObjectToArrayCaster extends Object implements ICaster
{

    /**
     * Value of casted recursion.
     */
    const RECURSION_VALUE = '*_recursion_*';

    /**
     * Indicate the type of value for casted recursion.
     * If is true, casted recursion will be self::RECURSION_VALUE.
     * If is false, casted recursion will not appears.
     *
     * @var bool
     */
    private $isExplicitRecursion = false;

    /**
     * Filter of visibility
     *
     * @var int
     */
    private $filter = AttributeReflection::NO_FILTER;

    /**
     * Indicate the kind of keys.
     * If is true, keys will be composed by full name of property (class name + property name)
     *
     * @var bool
     */
    private $isFullName = false;

    /**
     * Indicate if conversion also applies to objects in the properties and to values of arrays.
     *
     * @var bool
     */
    private $isRecursive = true;

    /**
     * List of object already casted.
     *
     * @var array
     */
    private $castedObjects = array();

    /**
     * Convert an object to an array.
     * The exported array contains all property values of the class and its parents, which are not transient.
     *
     * $filter allows you to filter by visibility properties.
     *
     * If $isFullName is true, array keys are composed by the class name dans the property name. If is false, only property name.
     *
     * If $isRecursive, the conversion also applies to objects in the properties and to values of arrays.
     *
     * @param object $object
     * @return array
     */
    public function cast($object)
    {
        $this->resetCastedObjects(); //reset the cache.
        return $this->extractValues($object);
    }

    /**
     * Setter of $isExplicitRecursion.
     *
     * @param boolean $isExplicitRecursion
     */
    public function setIsExplicitRecursion($isExplicitRecursion)
    {
        $this->isExplicitRecursion = $isExplicitRecursion;
    }

    /**
     * Getter of $isExplicitRecursion.
     *
     * @return boolean
     */
    public function isExplicitRecursion()
    {
        return $this->isExplicitRecursion;
    }

    /**
     * Setter of $filter.
     *
     * @param int $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Getter of $filter.
     *
     * @return int
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Setter of $isFullName.
     *
     * @param boolean $isFullName
     */
    public function setIsFullName($isFullName)
    {
        $this->isFullName = $isFullName;
    }

    /**
     * Getter of $isFullName.
     *
     * @return boolean
     */
    public function isFullName()
    {
        return $this->isFullName;
    }

    /**
     * Setter of $isRecursive.
     *
     * @param boolean $isRecursive
     */
    public function setIsRecursive($isRecursive)
    {
        $this->isRecursive = $isRecursive;
    }

    /**
     * Getter of $isRecursive.
     *
     * @return boolean
     */
    public function isRecursive()
    {
        return $this->isRecursive;
    }

    /**
     * Extracts properties from an object.
     *
     * @param object $object
     * @return array
     */
    private function extractValues($object)
    {
        $result = array();
        $this->addCastedObject($object);

        foreach ((new ObjectReflection($object))->getReflectionProperties($this->getFilter()) as $reflectedProperty) {
            $key = $reflectedProperty->getName($this->isFullName());
            if (!isset($result[$key]) && !$reflectedProperty->isTransient()) {
                $result = $this->addValue(
                    $result,
                    $key,
                    $reflectedProperty->getValue($object)
                );
            }
        }

        return $result;
    }

    /**
     * Filter value to added to $values according to the recursion.
     *
     * @param array $values
     * @param mixed $key
     * @param mixed $value
     * @return array
     */
    private function addValue(array $values, $key, $value)
    {
        $value = $this->handleValue($value);
        if ($this->isExplicitRecursion() || $value !== self::RECURSION_VALUE) {
            $values[$key] = $value;
        }
        return $values;
    }

    /**
     * Apply recursion of the conversion.
     *
     * @param mixed $value
     * @return array
     */
    private function handleValue($value)
    {
        if ($this->isRecursive()) {
            if (is_object($value)) {
                return $this->handleObjectValue($value);
            } elseif (is_array($value)) {
                return $this->handleArrayValue($value);
            }
        }
        return $value;
    }

    /**
     * Convert recursively an object.
     *
     * @param $object
     * @return array|string
     */
    private function handleObjectValue($object)
    {
        if ($this->isAlreadyCasted($object)) {
            return self::RECURSION_VALUE;
        }
        return $this->extractValues($object);
    }

    /**
     * Convert recursively an array.
     *
     * @param array $data
     * @return array
     */
    private function handleArrayValue(array $data)
    {
        $result = array();
        foreach ($data as $key => $value) {
            $result = $this->addValue($result, $key, $value);
        }
        return $result;
    }

    /**
     * Getter of $castedObjects.
     *
     * @return array
     */
    private function getCastedObjects()
    {
        return $this->castedObjects;
    }

    /**
     * reset of $castedObjects.
     *
     * @return array
     */
    private function resetCastedObjects()
    {
        return $this->castedObjects = array();
    }

    /**
     * Indicate if a object has been already casted.
     *
     * @param $object
     * @return bool
     */
    private function isAlreadyCasted($object)
    {
        return in_array($object, $this->getCastedObjects());
    }

    /**
     * Adder of $castedObjects.
     *
     * @param $object
     */
    private function addCastedObject($object)
    {
        $this->castedObjects[] = $object;
    }
}
