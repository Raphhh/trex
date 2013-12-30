<?php
namespace TRex\Core;

use TRex\Serialization\IArrayCastable;
use TRex\Serialization\IJsonCastable;

/**
 * Interface IObject
 * @package TRex\Core
 */
interface IObject extends IArrayCastable, IJsonCastable
{
    /**
     * Indicates whether the current object has dynamic properties access.
     *
     * @return bool
     */
    public function isDynamic();

    /**
     * Sets dynamic properties access.
     *
     * @param bool $isDynamic
     */
    public function setIsDynamic($isDynamic);

    /**
     * Adds a dynamic method to the object.
     *
     * @param string $name
     * @param \Closure $method
     */
    public function addMethod($name, \Closure $method);
}
 