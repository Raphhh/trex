<?php
namespace TRexTests\Reflection;

/**
 * Class ReflectionTest
 * @package TRexTests\Reflection
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
 