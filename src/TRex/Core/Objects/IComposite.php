<?php
namespace TRex\Core\Objects;

/**
 * Interface IComposite
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IComposite
{

    /**
     * Invokes a method on all the objects of the list.
     * Returns an array with each returned result.
     *
     * @param string $methodName
     * @param array $args
     * @return array
     */
    public function invoke($methodName, array $args = array());
}
