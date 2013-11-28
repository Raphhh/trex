<?php
namespace TRex\Reflection;

/**
 * Class ReflectionTest
 * @package TRex\Reflection
 */
class ReflectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test if reflection is abstract.
     */
    public function test__construct()
    {
        $reflectedClass = new \ReflectionClass('TRex\Reflection\Reflection');
        $this->assertTrue($reflectedClass->isAbstract());
    }
}
 