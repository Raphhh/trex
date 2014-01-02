<?php
namespace TRex\Serialization;

use TRex\Core\Json;

interface IJsonCastable
{
    /**
     * Convert an object to an JSON string.
     * The exported array contains all property values ofn the class and its parents, who are not transient.
     *
     * @param int $options
     * @return Json
     */
    public function toJson($options = JSON_PRETTY_PRINT);
}
