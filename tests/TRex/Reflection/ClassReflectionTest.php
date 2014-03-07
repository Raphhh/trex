<?php
namespace TRex\Reflection;

/**
 * Class ClassReflectionTest
 * @package TRex\Reflection
 */
class ClassReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Extends Object
     */
    public function testInheritance()
    {
        $this->assertInstanceOf('TRex\Core\Object', new ClassReflection('TRex\Reflection\resources\Foo'));
    }

    /**
     * Test array conversion.
     */
    public function testToArray()
    {
        $reflectedClass = new ClassReflection('TRex\Reflection\resources\Foo');
        $this->assertSame(array(), $reflectedClass->toArray());
    }

    /**
     * Tests reflector type.
     */
    public function teGetReflector()
    {
        $reflectedClass = new ClassReflection('TRex\Reflection\resources\Foo');
        $this->assertInstanceOf('\ReflectionClass', $reflectedClass->getReflector());
    }

    /**
     * Test the recovery of the name.
     */
    public function testGetName()
    {
        $reflectedClass = new ClassReflection('TRex\Reflection\resources\Foo');
        $this->assertSame('TRex\Reflection\resources\Foo', $reflectedClass->getName());
    }

    /**
     * Test if a class is transient.
     */
    public function testIsTransientTrue()
    {
        $reflectedClass = new ClassReflection('TRex\Reflection\resources\Foo');
        $this->assertTrue($reflectedClass->isTransient());
    }

    /**
     * Test if a class is not transient.
     */
    public function testIsTransientFalse()
    {
        $reflectedClass = new ClassReflection('TRex\Reflection\resources\Bar');
        $this->assertFalse($reflectedClass->isTransient());
    }

    /**
     * Test GetReflection properties without any filter.
     */
    public function testGetReflectionPropertiesWithoutFilter()
    {
        $reflectedClass = new ClassReflection('TRex\Reflection\resources\Foo');
        $reflectedProperties = $reflectedClass->getReflectionProperties();
        $this->assertTrue(is_array($reflectedProperties));
        $this->assertCount(4, $reflectedProperties);

        $this->assertInstanceOf('TRex\Reflection\PropertyReflection', $reflectedProperties[0]);
        $this->assertSame('TRex\Reflection\resources\Foo::foo', $reflectedProperties[0]->getName(true));

        $this->assertInstanceOf('TRex\Reflection\PropertyReflection', $reflectedProperties[1]);
        $this->assertSame('TRex\Reflection\resources\Foo::bar', $reflectedProperties[1]->getName(true));

        $this->assertInstanceOf('TRex\Reflection\PropertyReflection', $reflectedProperties[2]);
        $this->assertSame('TRex\Reflection\resources\Bar::foo', $reflectedProperties[2]->getName(true));

        $this->assertInstanceOf('TRex\Reflection\PropertyReflection', $reflectedProperties[3]);
        $this->assertSame('TRex\Reflection\resources\Bar::bar', $reflectedProperties[3]->getName(true));
    }

    /**
     * Test GetReflection properties with an example of a filter.
     */
    public function testGetReflectionPropertiesWithFilter()
    {
        $reflectedClass = new ClassReflection('TRex\Reflection\resources\Foo');
        $reflectedProperties = $reflectedClass->getReflectionProperties(
            AttributeReflection::PUBLIC_FILTER | AttributeReflection::PROTECTED_FILTER
        );
        $this->assertTrue(is_array($reflectedProperties));
        $this->assertCount(2, $reflectedProperties);

        $this->assertInstanceOf('TRex\Reflection\PropertyReflection', $reflectedProperties[0]);
        $this->assertSame('TRex\Reflection\resources\Foo::foo', $reflectedProperties[0]->getName(true));

        $this->assertInstanceOf('TRex\Reflection\PropertyReflection', $reflectedProperties[1]);
        $this->assertSame('TRex\Reflection\resources\Foo::bar', $reflectedProperties[1]->getName(true));
    }

    public function testGetAnnotations()
    {
        $reflectedClass = new ClassReflection('TRex\Reflection\resources\Foo');
        $this->assertInstanceOf('TRex\Annotation\Annotations', $reflectedClass->getAnnotations());
        $this->assertSame('TRex\Reflection\resources', $reflectedClass->getAnnotations()->get('package')->first());
    }
}
