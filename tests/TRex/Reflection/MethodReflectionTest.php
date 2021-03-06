<?php
namespace TRex\Reflection;

/**
 * Class MethodReflectionTest
 * @package TRex\Reflection
 */
class MethodReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Extends Object
     */
    public function testInheritance()
    {
        $this->assertInstanceOf('TRex\Core\Object', new MethodReflection('TRex\Reflection\resources\Foo', 'getFoo'));
    }

    /**
     * Test array conversion.
     */
    public function testToArray()
    {
        $reflectedMethod = new MethodReflection('TRex\Reflection\resources\Foo', 'getFoo');
        $this->assertSame(array(), $reflectedMethod->toArray());
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
        $reflectedMethod = new MethodReflection('TRex\Reflection\resources\Foo', 'getFoo');
        $this->assertSame('getFoo', $reflectedMethod->getName());
    }

    /**
     * Test the recovery of the full name.
     */
    public function testGetNameFull()
    {
        $reflectedMethod = new MethodReflection('TRex\Reflection\resources\Foo', 'getFoo');
        $this->assertSame('TRex\Reflection\resources\Foo::getFoo', $reflectedMethod->getName(true));
    }

    /**
     * Test if a method is transient.
     */
    public function testIsTransientTrue()
    {
        $reflectedMethod = new MethodReflection('TRex\Reflection\resources\Foo', 'getFoo');
        $this->assertTrue($reflectedMethod->isTransient());
    }

    /**
     * Test if a method is transient by its class.
     */
    public function testIsTransientTrueByClass()
    {
        $reflectedMethod = new MethodReflection('TRex\Reflection\resources\Foo', 'getBar');
        $this->assertTrue($reflectedMethod->isTransient());
    }

    /**
     * Test if a method is not transient.
     */
    public function testIsTransientFalse()
    {
        $reflectedMethod = new MethodReflection('TRex\Reflection\resources\Bar', 'getBar');
        $this->assertFalse($reflectedMethod->isTransient());
    }

    /**
     * Test the instantiation from PHP reflector.
     */
    public function testInstantiate()
    {
        $reflectedProperty = MethodReflection::instantiate(
            new \ReflectionMethod('TRex\Reflection\resources\Foo', 'getFoo')
        );
        $this->assertInstanceOf('TRex\Reflection\MethodReflection', $reflectedProperty);
        $this->assertSame('TRex\Reflection\resources\Foo::getFoo', $reflectedProperty->getName(true));
    }

    /**
     * Test the declaring class.
     */
    public function testGetClassReflection()
    {
        $reflectedProperty = new MethodReflection('TRex\Reflection\resources\Foo', 'getBar');
        $classReflection = $reflectedProperty->getClassReflection();
        $this->assertInstanceOf('TRex\Reflection\ClassReflection', $classReflection);
        $this->assertSame('TRex\Reflection\resources\Foo', $classReflection->getName());
    }

    public function testGetAnnotations()
    {
        $reflectedMethod = new MethodReflection('TRex\Reflection\resources\Foo', 'getBar');
        $this->assertInstanceOf('TRex\Annotation\Annotations', $reflectedMethod->getAnnotations());
        $this->assertSame('test', $reflectedMethod->getAnnotations()->get('tag')->first());
    }

    public function testGetTypeReflections()
    {
        $reflectedMethod = new MethodReflection('TRex\Reflection\resources\Foo', 'getBar');
        $this->assertCount(2, $reflectedMethod->getTypeReflections());

        $this->assertInstanceOf('TRex\Reflection\TypeReflection', $reflectedMethod->getTypeReflections()[0]);
        $this->assertSame(
            TypeReflection::STRING_TYPE,
            $reflectedMethod->getTypeReflections()[0]->getStandardizedType()
        );

        $this->assertInstanceOf('TRex\Reflection\TypeReflection', $reflectedMethod->getTypeReflections()[1]);
        $this->assertSame(TypeReflection::NULL_TYPE, $reflectedMethod->getTypeReflections()[1]->getStandardizedType());
    }
}
