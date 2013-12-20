<?php
namespace TRex\Serialization;

use TRex\Reflection\AttributeReflection;
use TRex\Serialization\resources\Foo;
use TRex\Serialization\resources\RecursiveArray;
use TRex\Serialization\resources\RecursiveClass;

/**
 * Class ObjectToArrayCasterTest
 * @package TRex\Serialization
 */
class ObjectToArrayCasterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Extends Object
     */
    public function testInheritance()
    {
        $this->assertInstanceOf('TRex\Core\Object', new ObjectToArrayCaster());
    }

    /**
     * Test array conversion.
     */
    public function testToArray()
    {
        $caster = new ObjectToArrayCaster();
        $this->assertSame(array(), $caster->toArray());
    }

    /**
     * Simple test of array conversion.
     */
    public function testCast()
    {
        $caster = new ObjectToArrayCaster();
        $this->assertSame(
            array(
                'bar' => 'bar from foo',
                'foo' => 'foo from bar',
            ),
            $caster->cast(new Foo())
        );
    }

    /**
     * Test array conversion with some filters.
     */
    public function testCastWithFilter()
    {
        $caster = new ObjectToArrayCaster();
        $caster->setFilter(AttributeReflection::PROTECTED_FILTER | AttributeReflection::PUBLIC_FILTER);
        $this->assertSame(
            array(
                'bar' => 'bar from foo',
            ),
            $caster->cast(new Foo())
        );
    }

    /**
     * Test array conversion with full name keys.
     */
    public function testCastWithFullName()
    {
        $caster = new ObjectToArrayCaster();
        $caster->setIsFullName(true);
        $this->assertSame(
            array(
                'TRex\Serialization\resources\Foo::bar' => 'bar from foo',
                'TRex\Serialization\resources\Bar::foo' => 'foo from bar',
                'TRex\Serialization\resources\Bar::bar' => 'bar from bar',
            ),
            $caster->cast(new Foo())
        );
    }

    /**
     * Test array conversion with explicit recursion of objects.
     */
    public function testCastWithObjectExplicitRecursion()
    {
        $recursiveObject = new RecursiveClass();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject1->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject2, $recursiveObject->recursiveObject1);

        $caster = new ObjectToArrayCaster();
        $caster->setIsExplicitRecursion(true);
        $this->assertSame(
            array(
                'recursiveObject0' => ObjectToArrayCaster::RECURSION_VALUE,
                'recursiveObject1' => array(
                    'recursiveObject0' => ObjectToArrayCaster::RECURSION_VALUE,
                    'recursiveObject1' => null,
                    'recursiveObject2' => null,
                ),
                'recursiveObject2' => ObjectToArrayCaster::RECURSION_VALUE,
            ),
            $caster->cast($recursiveObject)
        );
    }

    /**
     * Test array conversion with non explicit recursion of objects.
     */
    public function testCastWithObjectRecursion()
    {
        $recursiveObject = new RecursiveClass();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject1->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject2, $recursiveObject->recursiveObject1);

        $caster = new ObjectToArrayCaster();
        $this->assertSame(
            array(
                'recursiveObject1' => array(
                    'recursiveObject1' => null,
                    'recursiveObject2' => null,
                ),
            ),
            $caster->cast($recursiveObject)
        );
    }

    /**
     * Test array conversion without recursion of objects.
     */
    public function testCastWithoutObjectRecursion()
    {
        $recursiveObject = new RecursiveClass();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject1->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject2, $recursiveObject->recursiveObject1);

        $caster = new ObjectToArrayCaster();
        $caster->setIsExplicitRecursion(true);
        $caster->setIsRecursive(false);

        $this->assertSame(
            array(
                'recursiveObject0' => $recursiveObject,
                'recursiveObject1' => $recursiveObject->recursiveObject1,
                'recursiveObject2' => $recursiveObject->recursiveObject1,
            ),
            $caster->cast($recursiveObject)
        );
    }

    /**
     * Test array conversion with explicit recursion of arrays.
     */
    public function testCastWithArrayExplicitRecursion()
    {
        $recursiveObject = new RecursiveArray();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[1]->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[2], $recursiveObject->recursiveObjects[1]);

        $caster = new ObjectToArrayCaster();
        $caster->setIsExplicitRecursion(true);
        $this->assertSame(
            array(
                'recursiveObjects' => array(
                    0 => ObjectToArrayCaster::RECURSION_VALUE,
                    1 => array(
                        'recursiveObjects' => array(
                            0 => ObjectToArrayCaster::RECURSION_VALUE
                        ),
                    ),
                    2 => ObjectToArrayCaster::RECURSION_VALUE,
                ),
            ),
            $caster->cast($recursiveObject)
        );
    }

    /**
     * Test array conversion with no explicit recursion of arrays.
     */
    public function testCastWithArrayRecursion()
    {
        $recursiveObject = new RecursiveArray();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[1]->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[2], $recursiveObject->recursiveObjects[1]);

        $caster = new ObjectToArrayCaster();
        $this->assertSame(
            array(
                'recursiveObjects' => array(
                    1 => array(
                        'recursiveObjects' => array(),
                    ),
                ),
            ),
            $caster->cast($recursiveObject)
        );
    }

    /**
     * Test array conversion without recursion of arrays.
     */
    public function testCastWithoutArrayRecursion()
    {
        $recursiveObject = new RecursiveArray();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[1]->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[2], $recursiveObject->recursiveObjects[1]);

        $caster = new ObjectToArrayCaster();
        $caster->setIsExplicitRecursion(true);
        $caster->setIsRecursive(false);

        $this->assertSame(
            array(
                'recursiveObjects' => $recursiveObject->recursiveObjects,
            ),
            $caster->cast($recursiveObject)
        );
    }

    /**
     * Tests the reset of the cache of array conversion with recursion.
     */
    public function testCastDouble()
    {
        $recursiveObject = new RecursiveClass();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject1->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject2, $recursiveObject->recursiveObject1);

        $caster = new ObjectToArrayCaster();
        $caster->cast($recursiveObject);
        $this->assertSame(
            array(
                'recursiveObject1' => array(
                    'recursiveObject1' => null,
                    'recursiveObject2' => null,
                ),
            ),
            $caster->cast($recursiveObject)
        );
    }
}
 