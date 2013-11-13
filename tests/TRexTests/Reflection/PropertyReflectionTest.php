<?php
namespace TRexTests\Reflection;

use TRex\Reflection\PropertyReflection;
use TRexTests\Reflection\resources\Foo;

/**
 * Class PropertyReflectionTest
 * @package TRexTests\Reflection
 */
class PropertyReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test array conversion.
     */
    public function testToArray()
    {
        $reflectedProperty = new PropertyReflection('TRexTests\Reflection\resources\Foo', 'foo');
        $this->assertSame(array(), $reflectedProperty->toArray());
    }

    /**
     * Test the recovery of the name.
     */
    public function testGetName()
    {
        $reflectedProperty = new PropertyReflection('TRexTests\Reflection\resources\Foo', 'foo');
        $this->assertSame('foo', $reflectedProperty->getName());
    }

    /**
     * Test the recovery of the full name.
     */
    public function testGetNameFull()
    {
        $reflectedProperty = new PropertyReflection('TRexTests\Reflection\resources\Foo', 'foo');
        $this->assertSame('TRexTests\Reflection\resources\Foo::foo', $reflectedProperty->getName(true));
    }

    /**
     * Test if a property is transient.
     */
    public function testIsTransientTrue()
    {
        $reflectedProperty = new PropertyReflection('TRexTests\Reflection\resources\Foo', 'foo');
        $this->assertTrue($reflectedProperty->isTransient());
    }

    /**
     * Test if a property is not transient.
     */
    public function testIsTransientFalse()
    {
        $reflectedProperty = new PropertyReflection('TRexTests\Reflection\resources\Foo', 'bar');
        $this->assertFalse($reflectedProperty->isTransient());
    }

    /**
     * Test the instantiation from PHP reflector.
     */
    public function testInstantiate()
    {
        $reflectedProperty = PropertyReflection::instantiate(
            new \ReflectionProperty('TRexTests\Reflection\resources\Foo', 'foo')
        );
        $this->assertInstanceOf('TRex\Reflection\PropertyReflection', $reflectedProperty);
        $this->assertSame('TRexTests\Reflection\resources\Foo::foo', $reflectedProperty->getName(true));
    }

    /**
     * Test the declaring class.
     */
    public function testGetClassReflection()
    {
        $reflectedProperty = new PropertyReflection('TRexTests\Reflection\resources\Foo', 'bar');
        $classReflection = $reflectedProperty->getClassReflection();
        $this->assertInstanceOf('TRex\Reflection\ClassReflection', $classReflection);
        $this->assertSame('TRexTests\Reflection\resources\Foo', $classReflection->getName());
    }

    /**
     * Test the recovery of the value of a property.
     */
    public function testGetValue()
    {
        $reflectedProperty = new PropertyReflection('TRexTests\Reflection\resources\Foo', 'bar');
        $this->assertSame('bar', $reflectedProperty->getValue(new Foo()));
    }
}
 