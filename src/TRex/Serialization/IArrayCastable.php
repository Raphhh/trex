<?php
namespace TRex\Serialization;

/**
 * Interface IArrayCastable
 * @package TRex\Serialization
 */
interface IArrayCastable
{

    /**
     * Convert an object to an array.
     * The exported array contains all property values ofn the class and its parents, who are not transient.
     *
     * $filter allows you to filter by visibility properties.
     * If $filter is true, array keys are composed by the class name dans the property name. If is false, only property name.
     * If $isRecursive, the conversion also applies to objects in the properties.
     *
     * @return array
     */
    public function toArray();

}
