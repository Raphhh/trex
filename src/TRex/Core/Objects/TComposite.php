<?php
namespace TRex\Core\Objects;

/**
 * Class TComposite
 * Implements IComposite
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
trait TComposite
{

    /**
     * See IComposite.
     *
     * @param string $methodName
     * @param array $args
     * @return array
     */
    public function invoke($methodName, array $args = array())
    {
        $result = array();
        foreach ($this as $key => $object) {
            $result[$key] = call_user_func_array(array($object, $methodName), $args);
        }
        return $result;
    }
}
