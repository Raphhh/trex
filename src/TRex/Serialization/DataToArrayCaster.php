<?php
namespace TRex\Serialization;

use TRex\Core\Json;
use TRex\Core\Object;

/**
 * Class DataToArrayCaster
 * @package TRex\Serialization
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 */
class DataToArrayCaster extends Object implements ICaster
{
    /**
     * Format $data to an array.
     * $data could be a JSON string or an object.
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
