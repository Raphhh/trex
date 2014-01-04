<?php
namespace TRex\Serialization;

use TRex\Core\Object;

/**
 * Hasher calculate a hash string for different kind of data.
 *
 * @package TRex\Serialization
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Hasher extends Object
{

    /**
     * Current hash method.
     *
     * @var HashMethod
     */
    private $hashMethod;

    /**
     * Hash $data with the specified hash method.
     *
     * @param HashMethod $hashMethod
     * @param mixed $data
     * @return string
     */
    public static function hash(HashMethod $hashMethod, $data)
    {
        return call_user_func($hashMethod->getValue(), $data);
    }

    /**
     * Constructor.
     *
     * @param HashMethod $hashMethod
     */
    public function __construct(HashMethod $hashMethod = null)
    {
        $this->initHashMethod($hashMethod);
    }

    /**
     * Hash by class.
     *
     * @param object $object
     * @return string
     */
    public function hashClass($object)
    {
        return self::hash($this->getHashMethod(), get_class($object));
    }

    /**
     * Hash for object.
     *
     * @param object $object
     * @return string
     */
    public function hashObject($object)
    {
        return self::hash($this->getHashMethod(), serialize($object));
    }

    /**
     * Hash for array.
     *
     * @param array $array
     * @return string
     */
    public function hashArray(array $array)
    {
        return self::hash($this->getHashMethod(), serialize($array));
    }

    /**
     * Gets the current hash method.
     *
     * @return HashMethod
     */
    public function getHashMethod()
    {
        return $this->hashMethod;
    }

    /**
     * Sets the current hash method.
     *
     * @param HashMethod $hashMethod
     */
    public function setHashMethod(HashMethod $hashMethod)
    {
        $this->hashMethod = $hashMethod;
    }

    /**
     * Init $hashMethod.
     *
     * @param HashMethod $hashMethod
     */
    private function initHashMethod(HashMethod $hashMethod = null)
    {
        if (!$hashMethod) {
            $hashMethod = new HashMethod(HashMethod::SHA1);
        }
        $this->setHashMethod($hashMethod);
    }
}
