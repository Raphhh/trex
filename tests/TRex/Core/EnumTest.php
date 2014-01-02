<?php
namespace TRex\Core;

use TRex\Core\resources\FooEnum;

/**
 * Class EnumTest
 * test class for Enum.
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class EnumTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Extends Object
     */
    public function testInheritance()
    {
        $this->assertInstanceOf('TRex\Core\Object', new FooEnum('a'));
    }

    /**
     * Test array conversion.
     */
    public function testToArray()
    {
        $a = new FooEnum('a');
        $this->assertSame(array('value' => 'a'), $a->toArray());
    }

    /**
     * Instantiation with a valid value.
     */
    public function testValidValue()
    {
        new FooEnum('a');
        $this->assertTrue(true);
    }

    /**
     * Instantiation with a valid value.
     *
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum TRex\Core\resources\FooEnum
     */
    public function testNonValidValue()
    {
        new FooEnum('x');
    }

    /**
     * test geValue.
     */
    public function testGetValue()
    {
        $a = new FooEnum('a');
        $this->assertSame('a', $a->getValue());
    }

    /**
     * Tests getConstList.
     */
    public function testGetConstList()
    {
        $a = new FooEnum('a');
        $this->assertSame(array('A' => 'a', 'B' => 'b'), $a->getConstList());
    }

    /**
     * Tests is with valid value.
     */
    public function testIsOk()
    {
        $a = new FooEnum('a');
        $this->assertTrue($a->is('a'));
    }

    /**
     * Tests is with non valid value.
     */
    public function testIsKo()
    {
        $a = new FooEnum('a');
        $this->assertFalse($a->is('b'));
    }
}
