<?php
namespace TRex\Core;

use TRex\Serialization\IArrayCastable;
use TRex\Serialization\IJsonCastable;

/**
 * Base object.
 * Can be dynamic.
 * Can be converted.
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IObject extends IDynamicObject, IArrayCastable, IJsonCastable
{

}
