<?php
namespace TRex\Serialization;

use TRex\Core\Json;

/**
 * Describes an object which can be converted to a Json.
 *
 * @package TRex\Serialization
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IJsonCastable
{
    /**
     * Converts an object to a Json object.
     * The exported data contains all property values ofn the class and its parents, who are not transient.
     *
     * @param int $options
     * @return Json
     */
    public function toJson($options = JSON_PRETTY_PRINT);
}
