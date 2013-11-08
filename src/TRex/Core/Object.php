<?php
namespace TRex\Core;

/**
 * Class Object
 * @package TRex\Core
 */
abstract class Object
{

    /**
     * Indicate if properties can be create dynamically.
     *
     * @var bool
     */
    private $isDynamical = false;

    /**
     * List of dynamically added methods.
     * These methods are binded closures and can be called with selff:__call().
     *
     * @var \Closure[]
     */
    private $methods = array();

    /**
     * {@inheritDoc}
     *
     * @param string $propertyName
     * @return mixed
     * @throws \RuntimeException
     */
    public function __get($propertyName)
    {
        if (!$this->isDynamical()) {
            throw new \RuntimeException(sprintf('Try to access to an undefined property: %s::%s', get_class($this), $propertyName));
        } elseif (method_exists($this, 'get' . $propertyName)) {
            return $this->{'get' . $propertyName}();
        } else {
            return $this->$propertyName;
        }
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
        if (!$this->isDynamical()) {
            throw new \RuntimeException(sprintf('Try to mutate an undefined property: %s::%s', get_class($this), $propertyName));
        } elseif (method_exists($this, 'set' . $propertyName)) {
            return $this->{'set' . $propertyName}($value);
        } else {
            return $this->$propertyName = $value;
        }
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
        if($this->getMethod($methodName)){
            return call_user_func_array($this->getMethod($methodName), $args);
        }
        throw new \RuntimeException(sprintf('Try to call an undefined method: %s::%s()', get_class($this), $methodName));
    }

    /**
     * Getter of $isDynamical.
     *
     * @return boolean
     */
    public function isDynamical()
    {
        return $this->isDynamical;
    }

    /**
     * Setter of $isDynamical.
     *
     * @param boolean $isDynamical
     */
    public function setIsDynamical($isDynamical)
    {
        $this->isDynamical = $isDynamical;
    }

    /**
     * Adder of $methods.
     *
     * @param string $name
     * @param \Closure $method
     */
    public function addMethod($name, \Closure $method){
        $this->methods[$name] = \Closure::bind($method, $this, get_class($this));
    }

    /**
     * Getter of $methods.
     *
     * @param string $name
     * @return array
     */
    private function getMethod($name)
    {
        if(isset($this->methods[$name])){
            return $this->methods[$name];
        }
        return null;
    }
}
