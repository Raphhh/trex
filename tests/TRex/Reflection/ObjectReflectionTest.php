<?php
namespace TRex\Reflection;

use TRex\Reflection\resources\Foo;

/**
 * Class ObjectReflectionTest
 * @package TRex\Reflection
 */
class ObjectReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test array conversion.
     */
    public function testToArray()
    {
        $reflectedClass = new ObjectReflection(new Foo());
        $this->assertSame(array(), $reflectedClass->toArray());
    }

    /**
     * Test object getter.
     */
    public function testGetObject()
    {
        $object = new Foo();
        $reflectedClass = new ObjectReflection($object);
        $this->assertSame($object, $reflectedClass->getObject());
    }
}
 