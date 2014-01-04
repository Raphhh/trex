<?php
namespace TRex\Serialization;

/**
 * Interface ICaster.
 *
 * @package TRex\Serialization
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface ICaster
{
    /**
     * Converts.
     *
     * @param mixed $data
     * @return mixed
     */
    public function cast($data);
}
