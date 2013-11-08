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
     * $data is initial data to set in the object. Keys are property names, and value are initial property values.
     * $data could be a JSON string, an array or an array castable object.
     *
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        if($data){
            $this->initProperties($this->formatData($data));
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
        if (!$this->isDynamical()) {
            throw new \RuntimeException(sprintf('Try to access to an undefined property: %s::%s', get_class($this), $propertyName));
        }
        return $this->get($propertyName);
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
        }
        $this->set($propertyName, $value);
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

    /**
     * Dynamical getter of $propertyName.
     *
     * @param $propertyName
     * @return mixed
     */
    private function get($propertyName)
    {
        if (method_exists($this, 'get' . $propertyName)) {
            return $this->{'get' . $propertyName}();
        }
        return $this->$propertyName;
    }

    /**
     * Dynamical setter of $propertyName.
     *
     * @param string $propertyName
     * @param mixed $value
     */
    private function set($propertyName, $value)
    {
        if (method_exists($this, 'set' . $propertyName)) {
            $this->{'set' . $propertyName}($value);
        } else{
            $this->$propertyName = $value;
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
            $this->set($propertyName, $value);
        }
    }

    /**
     * Format $data to an array.
     * $data could be a JSON string or an object.
     *
     * @param mixed $data
     * @return array
     * @throws \InvalidArgumentException
     */
    private function formatData($data){
        if(is_string($data)){
            return json_decode($data, true);
        }
        if(is_array($data)){
            return $data;
        }
        if(is_object($data)){
            return (array) $data;
        }
        throw new \InvalidArgumentException(sprintf('$data must be a JSON, an array or an array castable object: %s given.', gettype($data)));
    }
}
