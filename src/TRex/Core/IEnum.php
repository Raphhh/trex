<?php
namespace TRex\Core;

/**
 * Enum represents a value in a possible list.
 * This ensures having a value among the constants of your class and prevents any other value.
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
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
     * Indicates whether the current value is $expectedValue.
     *
     * @param mixed $expectedValue
     * @return bool
     */
    public function is($expectedValue);
}
