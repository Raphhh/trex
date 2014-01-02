<?php
namespace TRex\Serialization;

use TRex\Serialization\resources\Bar;

class DataToArrayCasterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Extends Object
     */
    public function testInheritance()
    {
        $this->assertInstanceOf('TRex\Core\Object', new ObjectToArrayCaster());
    }

    /**
     * Tests cast with array param.
     */
    public function testFormatArray()
    {
        $caster = new DataToArrayCaster();
        $this->assertSame(array(1), $caster->cast(array(1)));
    }

    /**
     * Tests cast with json param.
     */
    public function testFormatJson()
    {
        $caster = new DataToArrayCaster();
        $this->assertSame(array(1), $caster->cast('[1]'));
    }

    /**
     * Tests cast with IArrayCastable param.
     */
    public function testFormatIArrayCastable()
    {
        $caster = new DataToArrayCaster();
        $this->assertSame(
            array(
                'foo' => 'foo from bar',
                'bar' => 'bar from bar',
            ),
            $caster->cast(new Bar())
        );
    }

    /**
     * Tests cast with std object param.
     */
    public function testFormatStdObject()
    {
        $object = new \stdClass();
        $object->a = 'test';

        $caster = new DataToArrayCaster();
        $this->assertSame(array('a' => 'test'), $caster->cast($object));
    }

    /**
     * Tests cast with string param.
     * json_decode for '1' return value 1. so we have to test if an exception is thrown.
     *
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage JSON string can not be decoded: "1" (Error: #0 - No errors)
     */
    public function testFormatString()
    {
        $caster = new DataToArrayCaster();
        $caster->cast('1');
    }

    /**
     * Tests cast with bool param.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $data must be a JSON, an array or an array castable object: boolean given.
     */
    public function testFormatBool()
    {
        $caster = new DataToArrayCaster();
        $caster->cast(true);
    }

    /**
     * Tests cast with integer param.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $data must be a JSON, an array or an array castable object: integer given.
     */
    public function testFormatInt()
    {
        $caster = new DataToArrayCaster();
        $caster->cast(1);
    }

    /**
     * Tests cast with null param.
     */
    public function testFormatNull()
    {
        $caster = new DataToArrayCaster();
        $this->assertSame(array(), $caster->cast(null));
    }
}
