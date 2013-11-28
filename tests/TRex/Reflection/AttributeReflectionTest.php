<?php
namespace TRex\Reflection;

/**
 * Class AttributeReflectionTest
 * @package TRex\Reflection
 */
class AttributeReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test if reflection is abstract.
     */
    public function test__construct()
    {
        $reflectedClass = new \ReflectionClass('TRex\Reflection\AttributeReflection');
        $this->assertTrue($reflectedClass->isAbstract());
    }
}
 