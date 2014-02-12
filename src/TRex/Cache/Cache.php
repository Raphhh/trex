<?php
namespace TRex\Cache;

use TRex\Core\Object;

/**
 * Class Cache
 * @package TRex\Cache
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 */
class Cache extends Object
{

    /**
     * @var
     */
    private $cachedObject;

    /**
     * @example Cache::call($object)->foo($args);
     * @param $cachedObject
     * @return Cache
     */
    public static function call($cachedObject)
    {
        $self = new self;
        $self->setCachedObject($cachedObject);
        return $self;
    }

    public function __call($methodName, array $arguments)
    {
        return ObjectCache::getInstance()->get(
            $this->getCachedObject(),
            $methodName,
            $arguments,
            array($this->getCachedObject(), $methodName)
        );
    }

    private function setCachedObject($cachedObject)
    {
        $this->cachedObject = $cachedObject;
    }

    private function getCachedObject()
    {
        return $this->cachedObject;
    }
}
