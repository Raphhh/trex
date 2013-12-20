<?php
namespace TRex\Serialization;

class DataToArrayCasterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests format with array param.
     */
    public function testFormatArray()
    {
        $caster = new DataToArrayCaster();
        $this->assertSame(array(1), $caster->format(array(1)));
    }

    /**
     * Tests format with json param.
     */
    public function testFormatJson()
    {
        $caster = new DataToArrayCaster();
        $this->assertSame(array(1), $caster->format('[1]'));
    }

    /**
     * Tests format with std object param.
     */
    public function testFormatStdObject()
    {
        $object = new \stdClass();
        $object->a = 'test';

        $caster = new DataToArrayCaster();
        $this->assertSame(array('a' => 'test'), $caster->format($object));
    }

    /**
     * Tests format with string param.
     * json_decode for '1' return value 1. so we have to test if an exception is thrown.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $data must be a JSON, an array or an array castable object: string given.
     */
    public function testFormatString()
    {
        $caster = new DataToArrayCaster();
        $caster->format('1');
    }

    /**
     * Tests format with bool param.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $data must be a JSON, an array or an array castable object: boolean given.
     */
    public function testFormatBool()
    {
        $caster = new DataToArrayCaster();
        $caster->format(true);
    }

    /**
     * Tests format with integer param.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $data must be a JSON, an array or an array castable object: integer given.
     */
    public function testFormatInt()
    {
        $caster = new DataToArrayCaster();
        $caster->format(1);
    }

    /**
     * Tests format with null param.
     */
    public function testFormatNull()
    {
        $caster = new DataToArrayCaster();
        $this->assertSame(array(), $caster->format(null));
    }
}
 