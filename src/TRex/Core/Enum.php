<?php
namespace TRex\Core;

/**
 * Class Enum
 * Enum respresent a value in a possible list.
 * It prevents any other value.
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
abstract class Enum extends Object implements IEnum
{
    /**
     * Current value.
     *
     * @var mixed
     */
    private $value;

    /**
     * {@inheritDoc}
     *
     * @param mixed $value
     * @throws \UnexpectedValueException
     */
    public function __construct($value)
    {
        if (!$this->isValidValue($value)) {
            throw new \UnexpectedValueException(sprintf('Value not a const in enum %s', get_class($this)));
        }
        $this->setValue($value);
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }

    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function getConstList()
    {
        $reflectedClass = new \ReflectionClass($this);
        return $reflectedClass->getConstants();
    }

    /**
     * {@inheritDoc}
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     *
     * @param $expectedValue
     * @return bool
     */
    public function is($expectedValue)
    {
        return $this->getValue() === $expectedValue;
    }

    /**
     * Setter og $value.
     *
     * @param mixed $value
     */
    private function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Indicates if the value is valid.
     * Tests if the value is in the possible values list.
     *
     * @param $value
     * @return bool
     */
    private function isValidValue($value)
    {
        return in_array($value, $this->getConstList(), true);
    }
}
 