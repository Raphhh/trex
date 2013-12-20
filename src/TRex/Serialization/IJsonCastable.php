<?php
namespace TRex\Serialization;

interface IJsonCastable
{
    /**
     * Convert an object to an JSON string.
     * The exported array contains all property values ofn the class and its parents, who are not transient.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = JSON_PRETTY_PRINT);
}
 