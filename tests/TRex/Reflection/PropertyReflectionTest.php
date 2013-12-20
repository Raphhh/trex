<?php
namespace TRex\Reflection;

use TRex\Reflection\resources\Foo;

/**
 * Class PropertyReflectionTest
 * @package TRex\Reflection
 */
class PropertyReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Extends Object
     */
    public function testInheritance()
    {
        $this->assertInstanceOf('TRex\Core\Object', new PropertyReflection('TRex\Reflection\resources\Foo', 'foo'));
    }

    /**
     * Test array conversion.
     */
    public function testToArray()
    {
        $reflectedProperty = new PropertyReflection('TRex\Reflection\resources\Foo', 'foo');
        $this->assertSame(array(), $reflectedProperty->toArray());
    }

    /**
     * Test the recovery of the name.
     */
    public function testGetName()
    {
        $reflectedProperty = new PropertyReflection('TRex\Reflection\resources\Foo', 'foo');
        $this->assertSame('foo', $reflectedProperty->getName());
    }

    /**
     * Test the recovery of the full name.
     */
    public function testGetNameFull()
    {
        $reflectedProperty = new PropertyReflection('TRex\Reflection\resources\Foo', 'foo');
        $this->assertSame('TRex\Reflection\resources\Foo::foo', $reflectedProperty->getName(true));
    }

    /**
     * Test if a property is transient.
     */
    public function testIsTransientTrue()
    {
        $reflectedProperty = new PropertyReflection('TRex\Reflection\resources\Foo', 'foo');
        $this->assertTrue($reflectedProperty->isTransient());
    }

    /**
     * Test if a property is transient by its class.
     */
    public function testIsTransientTrueByClass()
    {
        $reflectedProperty = new PropertyReflection('TRex\Reflection\resources\Foo', 'bar');
        $this->assertTrue($reflectedProperty->isTransient());
    }

    /**
     * Test if a property is not transient.
     */
    public function testIsTransientFalse()
    {
        $reflectedProperty = new PropertyReflection('TRex\Reflection\resources\Bar', 'bar');
        $this->assertFalse($reflectedProperty->isTransient());
    }

    /**
     * Test the instantiation from PHP reflector.
     */
    public function testInstantiate()
    {
        $reflectedProperty = PropertyReflection::instantiate(
            new \ReflectionProperty('TRex\Reflection\resources\Foo', 'foo')
        );
        $this->assertInstanceOf('TRex\Reflection\PropertyReflection', $reflectedProperty);
        $this->assertSame('TRex\Reflection\resources\Foo::foo', $reflectedProperty->getName(true));
    }

    /**
     * Test the declaring class.
     */
    public function testGetClassReflection()
    {
        $reflectedProperty = new PropertyReflection('TRex\Reflection\resources\Foo', 'bar');
        $classReflection = $reflectedProperty->getClassReflection();
        $this->assertInstanceOf('TRex\Reflection\ClassReflection', $classReflection);
        $this->assertSame('TRex\Reflection\resources\Foo', $classReflection->getName());
    }

    /**
     * Test the recovery of the value of a property.
     */
    public function testGetValue()
    {
        $reflectedProperty = new PropertyReflection('TRex\Reflection\resources\Foo', 'bar');
        $this->assertSame('bar', $reflectedProperty->getValue(new Foo()));
    }
}
 