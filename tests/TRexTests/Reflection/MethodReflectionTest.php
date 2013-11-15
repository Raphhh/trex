<?php
namespace TRexTests\Reflection;

use TRex\Reflection\MethodReflection;

/**
 * Class MethodReflectionTest
 * @package TRexTests\Reflection
 */
class MethodReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test array conversion.
     */
    public function testToArray()
    {
        $reflectedMethod = new MethodReflection('TRexTests\Reflection\resources\Foo', 'getFoo');
        $this->assertSame(array(), $reflectedMethod->toArray());
    }

    /**
     * Test the recovery of the name.
     */
    public function testGetName()
    {
        $reflectedMethod = new MethodReflection('TRexTests\Reflection\resources\Foo', 'getFoo');
        $this->assertSame('getFoo', $reflectedMethod->getName());
    }

    /**
     * Test the recovery of the full name.
     */
    public function testGetNameFull()
    {
        $reflectedMethod = new MethodReflection('TRexTests\Reflection\resources\Foo', 'getFoo');
        $this->assertSame('TRexTests\Reflection\resources\Foo::getFoo', $reflectedMethod->getName(true));
    }

    /**
     * Test if a method is transient.
     */
    public function testIsTransientTrue()
    {
        $reflectedMethod = new MethodReflection('TRexTests\Reflection\resources\Foo', 'getFoo');
        $this->assertTrue($reflectedMethod->isTransient());
    }

    /**
     * Test if a method is not transient.
     */
    public function testIsTransientFalse()
    {
        $reflectedMethod = new MethodReflection('TRexTests\Reflection\resources\Foo', 'getBar');
        $this->assertFalse($reflectedMethod->isTransient());
    }

    /**
     * Test the instantiation from PHP reflector.
     */
    public function testInstantiate()
    {
        $reflectedProperty = MethodReflection::instantiate(
            new \ReflectionMethod('TRexTests\Reflection\resources\Foo', 'getFoo')
        );
        $this->assertInstanceOf('TRex\Reflection\MethodReflection', $reflectedProperty);
        $this->assertSame('TRexTests\Reflection\resources\Foo::getFoo', $reflectedProperty->getName(true));
    }

    /**
     * Test the declaring class.
     */
    public function testGetClassReflection()
    {
        $reflectedProperty = new MethodReflection('TRexTests\Reflection\resources\Foo', 'getBar');
        $classReflection = $reflectedProperty->getClassReflection();
        $this->assertInstanceOf('TRex\Reflection\ClassReflection', $classReflection);
        $this->assertSame('TRexTests\Reflection\resources\Foo', $classReflection->getName());
    }
}
 