<?php
namespace TRex\Serialization;

use TRex\Core\Object;
use TRex\Reflection\AttributeReflection;
use TRex\Reflection\ObjectReflection;

/**
 * Class Caster.
 * Object conversion handler.
 *
 * @package TRex\Serialization
 * @transient
 */
class Caster extends Object
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
    private $isExplicitRecursion;

    /**
     * List of object already casted.
     *
     * @var array
     */
    private $castedObjects = array();

    /**
     * @param bool $isExplicitRecursion
     */
    public function __construct($isExplicitRecursion = false)
    {
        $this->setIsExplicitRecursion($isExplicitRecursion);
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
     * Format $data to an array.
     * $data could be a JSON string or an object.
     *
     * @param mixed $data
     * @return array
     * @throws \InvalidArgumentException
     */
    public function format($data)
    {
        if (!$data) {
            return array();
        }
        if (is_string($data)) {
            return json_decode($data, true);
        }
        if (is_array($data)) {
            return $data;
        }
        if (is_object($data)) {
            return (array)$data;
        }
        throw new \InvalidArgumentException(sprintf(
            '$data must be a JSON, an array or an array castable object: %s given.',
            gettype($data)
        ));
    }

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
     * @param int $filter
     * @param bool $isFullName
     * @param bool $isRecursive
     * @return array
     */
    public function castToArray(
        $object,
        $filter = AttributeReflection::NO_FILTER,
        $isFullName = false,
        $isRecursive = true
    ) {
        return $this->extractValues(new ObjectReflection($object), new CasterParam($filter, $isFullName, $isRecursive));
    }

    /**
     * Extract properties from a reflector.
     *
     * @param ObjectReflection $reflectedObject
     * @param CasterParam $param
     * @return array
     */
    private function extractValues(ObjectReflection $reflectedObject, CasterParam $param)
    {
        $result = array();
        $this->addCastedObject($reflectedObject->getObject());

        foreach ($reflectedObject->getReflectionProperties($param->getFilter()) as $reflectedProperty) {
            if (
                !isset($result[$reflectedProperty->getName($param->isFullName())])
                && !$reflectedProperty->isTransient()
                && !$reflectedProperty->getClassReflection()->isTransient()
            ) {
                $result = $this->addValue(
                    $result,
                    $reflectedProperty->getName($param->isFullName()),
                    $reflectedProperty->getValue($reflectedObject->getObject()),
                    $param
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
     * @param CasterParam $param
     * @return array
     */
    private function addValue(array $values, $key, $value, CasterParam $param)
    {
        $value = $this->handleValue($value, $param);
        if ($this->isExplicitRecursion() || $value !== self::RECURSION_VALUE) {
            $values[$key] = $value;
        }
        return $values;
    }

    /**
     * Apply recursion of the conversion.
     *
     * @param mixed $value
     * @param CasterParam $param
     * @return array
     */
    private function handleValue($value, CasterParam $param)
    {
        if ($param->isRecursive()) {
            if (is_object($value)) {
                return $this->handleObjectValue($value, $param);
            } elseif (is_array($value)) {
                return $this->handleArrayValue($value, $param);
            }
        }
        return $value;
    }

    /**
     * Convert recursively an object.
     *
     * @param $object
     * @param CasterParam $param
     * @return array|string
     */
    private function handleObjectValue($object, CasterParam $param)
    {
        if ($this->isAlreadyCasted($object)) {
            return self::RECURSION_VALUE;
        }
        return $this->extractValues(new ObjectReflection($object), $param);
    }

    /**
     * Convert recursively an array.
     *
     * @param array $data
     * @param CasterParam $param
     * @return array
     */
    private function handleArrayValue(array $data, CasterParam $param)
    {
        $result = array();
        foreach ($data as $key => $value) {
            $result = $this->addValue($result, $key, $value, $param);
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
     * Setter of $castedObjects.
     *
     * @param array $castedObjects
     */
    private function setCastedObjects($castedObjects)
    {
        $this->castedObjects = $castedObjects;
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
