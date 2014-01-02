<?php
namespace TRex\Core;

/**
 * Interface IDynamicObject
 * @package TRex\Core
 */
interface IDynamicObject
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
    public function setDynamic($isDynamic);

    /**
     * Adds a dynamic method to the object.
     *
     * @param string $name
     * @param \Closure $method
     */
    public function addMethod($name, \Closure $method);
}
 