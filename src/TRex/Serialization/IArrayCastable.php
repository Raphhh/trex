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
     * @return array
     */
    public function toArray();
}
