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
     * Getter of $isDynamical
     *
     * @return boolean
     */
    public function isDynamical()
    {
        return $this->isDynamical;
    }

    /**
     * Setter of $isDynamical
     *
     * @param boolean $isDynamical
     */
    public function setIsDynamical($isDynamical)
    {
        $this->isDynamical = $isDynamical;
    }
}
