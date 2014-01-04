<?php
namespace TRex\Serialization;

/**
 * Describes an object which can be converted to an array.
 *
 * @package TRex\Serialization
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IArrayCastable
{

    /**
     * Converts an object to an array.
     * The exported array contains all property values of the class and its parents, which are not transient.
     *
     * @return array
     */
    public function toArray();
}
