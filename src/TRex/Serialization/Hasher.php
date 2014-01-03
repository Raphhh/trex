<?php
namespace TRex\Serialization;

use TRex\Core\Object;

/**
 * Class Hasher
 * @package TRex\Serialization
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Hasher extends Object
{

    /**
     * @var HashMethod
     */
    private $hashMethod;

    /**
     * @param $hashMethod
     * @param $data
     * @return mixed
     */
    public static function hash(HashMethod $hashMethod, $data)
    {
        return call_user_func($hashMethod->getValue(), $data);
    }

    /**
     * @param HashMethod $hashMethod
     */
    public function __construct(HashMethod $hashMethod = null)
    {
        $this->initHashMethod($hashMethod);
    }

    /**
     * @param $object
     * @return mixed
     */
    public function hashClass($object)
    {
        return self::hash($this->getHashMethod(), get_class($object));
    }

    /**
     * @param $object
     * @return mixed
     */
    public function hashObject($object)
    {
        return self::hash($this->getHashMethod(), serialize($object));
    }

    /**
     * @param array $array
     * @return mixed
     */
    public function hashArray(array $array)
    {
        return self::hash($this->getHashMethod(), serialize($array));
    }

    /**
     * @return HashMethod
     */
    public function getHashMethod()
    {
        return $this->hashMethod;
    }

    /**
     * @param HashMethod $hashMethod
     */
    public function setHashMethod(HashMethod $hashMethod)
    {
        $this->hashMethod = $hashMethod;
    }

    /**
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
