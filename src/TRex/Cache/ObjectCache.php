<?php
namespace TRex\Cache;

use TRex\Core\Object;
use TRex\Serialization\Hasher;

/**
 * Class Cache
 * @package TRex\Cache
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @todo has to be tested
 */
class ObjectCache extends Object
{

    /**
     * @var
     */
    private $cachedObject;

    /**
     * @var array
     */
    private $caches = array();

    /**
     * @var ObjectCache
     */
    private static $instance;

    /**
     * @example Cache::call($object)->foo($args);
     * @param $cachedObject
     * @return ObjectCache
     */
    public static function call($cachedObject)
    {
        self::getInstance()->setCachedObject($cachedObject);
        return self::getInstance();
    }

    /**
     * @return ObjectCache
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __call($methodName, array $arguments)
    {
        return $this->get(
            $this->getCachedObject(),
            $methodName,
            $arguments,
            array($this->getCachedObject(), $methodName)
        );
    }

    public function toArray()
    {
        return $this->caches;
    }

    public function get($cachedObject, $methodName, array $arguments, callable $callback)
    {
        list($classKey, $methodKey, $argumentsKey) = $this->getKeys($cachedObject, $methodName, $arguments);
        if (!$this->hasCache($classKey, $methodKey, $argumentsKey)) {
            $this->addCache($classKey, $methodKey, $argumentsKey, call_user_func_array($callback, $arguments));
        }
        return $this->caches[$classKey][$methodKey][$argumentsKey];
    }

    public function clean($cachedObject = null, $methodName = '', array $arguments = array())
    {
        list($classKey, $methodKey, $argumentsKey) = $this->getKeys($cachedObject, $methodName, $arguments);
        if ($cachedObject && $methodName && $arguments) {
            if ($this->hasCache($classKey, $methodKey, $argumentsKey)) {
                $this->caches[$classKey][$methodKey][$argumentsKey] = array();
            }
        } elseif ($cachedObject && $methodName) {
            if ($this->hasCacheForMethod($classKey, $methodKey)) {
                $this->caches[$classKey][$methodKey] = array();
            }
        }
        if ($cachedObject) {
            if ($this->hasCacheForClass($classKey)) {
                $this->caches[$classKey] = array();
            }
        } else {
            $this->caches = array();
        }
    }

    private function hasCache($classKey, $methodName, $argumentsKey)
    {
        return isset($this->caches[$classKey][$methodName][$argumentsKey]);
    }

    private function hasCacheForClass($classKey)
    {
        return isset($this->caches[$classKey]);
    }

    private function hasCacheForMethod($classKey, $methodName)
    {
        return isset($this->caches[$classKey][$methodName]);
    }

    private function addCache($classKey, $methodName, $argumentsKey, $value)
    {
        $this->caches[$classKey][$methodName][$argumentsKey] = $value;
    }

    private function setCachedObject($cachedObject)
    {
        $this->cachedObject = $cachedObject;
    }

    private function getCachedObject()
    {
        return $this->cachedObject;
    }

    private function getKeys($cachedObject = null, $methodName = '', array $arguments = array())
    {
        $hasher = new Hasher();
        return array(
            $cachedObject ? $hasher->hashClass($cachedObject) : '',
            $methodName,
            $arguments ? $hasher->hashArray($arguments) : ''
        );
    }
}
