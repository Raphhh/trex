<?php
namespace TRex\Core;

/**
 * Interface IEnum
 * @package TRex\Core
 */
interface IEnum
{

    /**
     * Constructor.
     *
     * @param mixed $value
     */
    public function __construct($value);

    /**
     * Cast to string.
     *
     * @return string
     */
    public function __toString();

    /**
     * Returns the list of the possible values.
     *
     * @return array
     */
    public function getConstList();

    /**
     * Returns the current value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Indicates if the current value is $expectedValue.
     *
     * @param mixed $expectedValue
     * @return bool
     */
    public function is($expectedValue);
}
