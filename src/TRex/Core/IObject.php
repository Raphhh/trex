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
     * Indicates if the object has dynamical properties access.
     *
     * @return bool
     */
    public function isDynamical();

    /**
     * Sets dynamical properties access.
     *
     * @param bool $isDynamical
     */
    public function setIsDynamical($isDynamical);

    /**
     * Adds a dynamical method to the object.
     *
     * @param string $name
     * @param \Closure $method
     */
    public function addMethod($name, \Closure $method);
}
 