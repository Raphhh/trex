<?php
namespace TRex\Core;

/**
 * Enum represents a value in a possible list.
 * This ensures having a value among the constants of your class and prevents any other value.
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
     * Constructor.
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
     * @param mixed $expectedValue
     * @return bool
     */
    public function is($expectedValue)
    {
        return $this->getValue() === $expectedValue;
    }

    /**
     * Setter of $value.
     *
     * @param mixed $value
     */
    private function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Indicates whether the value is valid.
     * Tests whether the value is in the possible values list.
     *
     * @param mixed $value
     * @return bool
     */
    private function isValidValue($value)
    {
        return in_array($value, $this->getConstList(), true);
    }
}
