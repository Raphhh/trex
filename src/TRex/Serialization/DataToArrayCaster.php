<?php
namespace TRex\Serialization;

use TRex\Core\Json;
use TRex\Core\Object;

/**
 * DataToArrayCaster converts any data to array.
 *
 * @package TRex\Serialization
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 */
class DataToArrayCaster extends Object implements ICaster
{
    /**
     * Formats $data to an array.
     * $data could be:
     *  - JSON string
     *  - object
     *  - array
     *  - null
     *  - IArrayCastable
     *
     * @param mixed $data
     * @return array
     * @throws \InvalidArgumentException
     */
    public function cast($data)
    {
        switch (true) {
            case is_null($data):
                return array();

            case is_array($data):
                return $data;

            case $data instanceof IArrayCastable:
                return $data->toArray();

            case is_object($data):
                return (array)$data;

            case is_string($data):
                return Json::createFromString($data)->toArray();
        }
        throw new \InvalidArgumentException(
            sprintf('$data must be a JSON, an array or an array castable object: %s given.', gettype($data))
        );
    }
}
