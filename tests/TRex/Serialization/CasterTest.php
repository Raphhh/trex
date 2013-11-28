<?php
namespace TRex\Serialization;

use TRex\Reflection\AttributeReflection;
use TRex\Serialization\resources\Foo;
use TRex\Serialization\resources\RecursiveArray;
use TRex\Serialization\resources\RecursiveClass;

/**
 * Class CasterTest
 * @package TRex\Serialization
 */
class CasterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test array conversion.
     */
    public function testToArray()
    {
        $caster = new Caster();
        $this->assertSame(array(), $caster->toArray());
    }

    /**
     * Simple test of array conversion.
     */
    public function testCastToArray()
    {
        $caster = new Caster();
        $this->assertSame(
            array(
                'bar' => 'bar from foo',
                'foo' => 'foo from bar',
            ),
            $caster->castToArray(new Foo())
        );
    }

    /**
     * Test array conversion with some filters.
     */
    public function testCastToArrayWithFilter()
    {
        $caster = new Caster();
        $this->assertSame(
            array(
                'bar' => 'bar from foo',
            ),
            $caster->castToArray(new Foo(), AttributeReflection::PROTECTED_FILTER | AttributeReflection::PUBLIC_FILTER)
        );
    }

    /**
     * Test array conversion with full name keys.
     */
    public function testCastToArrayWithFullName()
    {
        $caster = new Caster();
        $this->assertSame(
            array(
                'TRex\Serialization\resources\Foo::bar' => 'bar from foo',
                'TRex\Serialization\resources\Bar::foo' => 'foo from bar',
                'TRex\Serialization\resources\Bar::bar' => 'bar from bar',
            ),
            $caster->castToArray(new Foo(), AttributeReflection::NO_FILTER, true)
        );
    }

    /**
     * Test array conversion with explicit recursion of objects.
     */
    public function testCastToArrayWithObjectExplicitRecursion()
    {
        $recursiveObject = new RecursiveClass();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject1->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject2, $recursiveObject->recursiveObject1);

        $caster = new Caster();
        $caster->setIsExplicitRecursion(true);
        $this->assertSame(
            array(
                'recursiveObject0' => Caster::RECURSION_VALUE,
                'recursiveObject1' => array(
                    'recursiveObject0' => Caster::RECURSION_VALUE,
                    'recursiveObject1' => null,
                    'recursiveObject2' => null,
                ),
                'recursiveObject2' => Caster::RECURSION_VALUE,
            ),
            $caster->castToArray($recursiveObject)
        );
    }

    /**
     * Test array conversion with non explicit recursion of objects.
     */
    public function testCastToArrayWithObjectRecursion()
    {
        $recursiveObject = new RecursiveClass();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject1->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject2, $recursiveObject->recursiveObject1);

        $caster = new Caster();
        $this->assertSame(
            array(
                'recursiveObject1' => array(
                    'recursiveObject1' => null,
                    'recursiveObject2' => null,
                ),
            ),
            $caster->castToArray($recursiveObject)
        );
    }

    /**
     * Test array conversion without recursion of objects.
     */
    public function testCastToArrayWithoutObjectRecursion()
    {
        $recursiveObject = new RecursiveClass();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject1->recursiveObject0, $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObject2, $recursiveObject->recursiveObject1);

        $caster = new Caster();
        $caster->setIsExplicitRecursion(true);

        $this->assertSame(
            array(
                'recursiveObject0' => $recursiveObject,
                'recursiveObject1' => $recursiveObject->recursiveObject1,
                'recursiveObject2' => $recursiveObject->recursiveObject1,
            ),
            $caster->castToArray($recursiveObject, AttributeReflection::NO_FILTER, false, false)
        );
    }

    /**
     * Test array conversion with explicit recursion of arrays.
     */
    public function testCastToArrayWithArrayExplicitRecursion()
    {
        $recursiveObject = new RecursiveArray();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[1]->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[2], $recursiveObject->recursiveObjects[1]);

        $caster = new Caster();
        $caster->setIsExplicitRecursion(true);
        $this->assertSame(
            array(
                'recursiveObjects' => array(
                    0 => Caster::RECURSION_VALUE,
                    1 => array(
                        'recursiveObjects' => array(
                            0 => Caster::RECURSION_VALUE
                        ),
                    ),
                    2 => Caster::RECURSION_VALUE,
                ),
            ),
            $caster->castToArray($recursiveObject)
        );
    }

    /**
     * Test array conversion with no explicit recursion of arrays.
     */
    public function testCastToArrayWithArrayRecursion()
    {
        $recursiveObject = new RecursiveArray();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[1]->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[2], $recursiveObject->recursiveObjects[1]);

        $caster = new Caster();
        $this->assertSame(
            array(
                'recursiveObjects' => array(
                    1 => array(
                        'recursiveObjects' => array(),
                    ),
                ),
            ),
            $caster->castToArray($recursiveObject)
        );
    }

    /**
     * Test array conversion without recursion of arrays.
     */
    public function testCastToArrayWithoutArrayRecursion()
    {
        $recursiveObject = new RecursiveArray();
        $recursiveObject->initRecursion();

        $this->assertSame($recursiveObject->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[1]->recursiveObjects[0], $recursiveObject);
        $this->assertSame($recursiveObject->recursiveObjects[2], $recursiveObject->recursiveObjects[1]);

        $caster = new Caster();
        $caster->setIsExplicitRecursion(true);

        $this->assertSame(
            array(
                'recursiveObjects' => $recursiveObject->recursiveObjects,
            ),
            $caster->castToArray($recursiveObject, AttributeReflection::NO_FILTER, false, false)
        );
    }
}
 