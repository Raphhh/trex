<?php
namespace TRex\Core;

use TRex\Serialization\DataToArrayCaster;
use TRex\Serialization\ObjectToArrayCaster;

/**
 * Base object.
 * Can be dynamic.
 * Can be converted.
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
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
     * Constructor.
     *
     * $data is initial data to set in the object. Keys are property names, and values are initial property values.
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
     * See PHP doc.
     *
     * @link http://www.php.net/manual/en/language.oop5.overloading.php
     * @param string $propertyName
     * @return mixed
     * @throws \RuntimeException
     * @internal
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
     * See PHP doc.
     *
     * @link http://www.php.net/manual/en/language.oop5.overloading.php
     * @param string $propertyName
     * @param mixed $value
     * @return mixed
     * @throws \RuntimeException
     * @internal
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
     * See PHP doc.
     *
     * Call dynamically a method added with self::addMethod().
     * After having added a method, it is possible to call it like a declared method $object->newMethod($arg)
     *
     * @link http://www.php.net/manual/en/language.oop5.overloading.php
     * @param string $methodName
     * @param array $args
     * @throws \RuntimeException
     * @return mixed
     * @internal
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
     * See PHP doc.
     *
     * @link http://php.net/manual/en/language.oop5.magic.php
     * @return string
     */
    public function __toString()
    {
        return (string)$this->toJson();
    }

    /**
     *  Getter of $methods.
     *
     * @param string $name
     * @return array
     */
    protected function getMethod($name)
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
    protected function getProperty($name)
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
