<?php
namespace TRex\Core;

use TRex\Cache\ObjectCache;
use TRex\Serialization\DataToArrayCaster;
use TRex\Serialization\ObjectToArrayCaster;

/**
 * Class Object
 * @package TRex\Core
 * @transient
 */
abstract class Object implements IObject
{

    /**
     * Indicates whether the properties of the current object can be created dynamically.
     *
     * @var bool
     */
    private $isDynamic = false;

    /**
     * List of dynamically added methods.
     * These methods are binded closures and can be called with self:__call().
     *
     * @var \Closure[]
     */
    private $methods = array();

    /**
     * {@inheritDoc}
     *
     * $data is initial data to set in the object. Keys are property names, and value are initial property values.
     * $data could be a JSON string, an array or an array castable object.
     *
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        if ($data) {
            $this->initProperties((new DataToArrayCaster())->cast($data));
        }
    }

    /**
     * {@inheritDoc}
     *
     * @param string $propertyName
     * @return mixed
     * @throws \RuntimeException
     */
    public function __get($propertyName)
    {
        if (!$this->isDynamic()) {
            throw new \RuntimeException(
                sprintf('Try to access to an undefined property: %s::%s', get_class($this), $propertyName)
            );
        }
        return $this->getProperty($propertyName);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $propertyName
     * @param mixed $value
     * @return mixed
     * @throws \RuntimeException
     */
    public function __set($propertyName, $value)
    {
        if (!$this->isDynamic()) {
            throw new \RuntimeException(
                sprintf('Try to mutate an undefined property: %s::%s', get_class($this), $propertyName)
            );
        }
        $this->setProperty($propertyName, $value);
    }

    /**
     * {@inheritDoc}
     *
     * Call dynamically a method added with self::addMethod().
     * After having added a method, it is possible to call it like a declared method $object->newMethod($arg)
     *
     * @param string $methodName
     * @param array $args
     * @throws \RuntimeException
     * @return mixed
     */
    public function __call($methodName, array $args)
    {
        if ($this->getMethod($methodName)) {
            return call_user_func_array($this->getMethod($methodName), $args);
        }
        throw new \RuntimeException(
            sprintf('Try to call an undefined method: %s::%s()', get_class($this), $methodName)
        );
    }

    /**
     * {@inheritDoc}
     *
     * @return boolean
     */
    public function isDynamic()
    {
        return $this->isDynamic;
    }

    /**
     * {@inheritDoc}
     *
     * @param boolean $isDynamic
     */
    public function setDynamic($isDynamic)
    {
        $this->isDynamic = $isDynamic;
    }

    /**
     * {@inheritDoc}
     *
     * @param string $name
     * @param \Closure $method
     */
    public function addMethod($name, \Closure $method)
    {
        $this->methods[$name] = \Closure::bind($method, $this, get_class($this));
    }

    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function toArray()
    {
        return (new ObjectToArrayCaster())->cast($this);
    }

    /**
     * {@inheritDoc}
     *
     * @return Json
     */
    public function toJson($options = JSON_PRETTY_PRINT)
    {
        $result = new Json($this);
        $result->setOptions($options);
        return $result;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->toJson();
    }

    /**
     * function foo($arg){
     *                 return $this->cache(function($arg){ $this->prop + $arg; });
     * }
     * @param \Closure $closure
     * @param bool $mustBeRefreshed
     * @return mixed
     * @todo has to be tested
     */
    protected function cache(\Closure $closure, $mustBeRefreshed = true)
    {
        $backTraces = debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        if ($mustBeRefreshed) {
            ObjectCache::getInstance()->clean($this, $backTraces[1]['function'], $backTraces[1]['args']);
        }
        return ObjectCache::getInstance()->get(
            $this,
            $backTraces[1]['function'],
            $backTraces[1]['args'],
            \Closure::bind($closure, $this, get_class($this))
        );
    }

    /**
     *  Getter of $methods.
     *
     * @param string $name
     * @return array
     */
    private function getMethod($name)
    {
        if (isset($this->methods[$name])) {
            return $this->methods[$name];
        }
        return null;
    }

    /**
     * Dynamic getter of $propertyName.
     *
     * @param string $name
     * @return mixed
     */
    private function getProperty($name)
    {
        if (method_exists($this, 'get' . $name)) {
            return $this->{'get' . $name}();
        }
        return $this->$name;
    }

    /**
     * Dynamic setter of $propertyName.
     *
     * @param string $name
     * @param mixed $value
     */
    private function setProperty($name, $value)
    {
        if (method_exists($this, 'set' . $name)) {
            $this->{'set' . $name}($value);
        } else {
            $this->$name = $value;
        }
    }

    /**
     * Init property values.
     * $data is initial data to set in the object. Keys are property names, and value are initial property values.
     *
     * @param array $data
     */
    private function initProperties(array $data)
    {
        foreach ($data as $propertyName => $value) {
            $this->setProperty($propertyName, $value);
        }
    }
}
