<?php
namespace TRex\Core;

use TRex\Core\resources\Foo;

/**
 * Class ObjectTest
 * @package TRex\Core
 */
class ObjectTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test if Object is abstract.
     */
    public function testAbstract()
    {
        $reflectedClass = new \ReflectionClass('TRex\Core\Object');
        $this->assertTrue($reflectedClass->isAbstract());
    }

    /**
     * Test property is not accessible when Object is not dynamic.
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Try to access to an undefined property: TRex\Core\resources\Foo::none
     */
    public function test__getPrevented()
    {
        $foo = new Foo();
        $this->assertNull($foo->none);
    }

    /**
     * Test property is accessible by getter when Object is dynamic.
     */
    public function test__getByGetter()
    {
        $foo = new Foo();
        $foo->setDynamic(true);
        $this->assertSame('BAR', $foo->bar);
    }

    /**
     * Test property is directly accessible when Object is dynamic.
     *
     * @expectedException \PHPUnit_Framework_Error_Notice
     */
    public function test__getAllowed()
    {
        $foo = new Foo();
        $foo->setDynamic(true);
        $this->assertNull($foo->none);
    }

    /**
     * Test property is not editable when Object is not dynamic.
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Try to mutate an undefined property: TRex\Core\resources\Foo::none
     */
    public function test__setPrevented()
    {
        $foo = new Foo();
        $foo->none = 'none';
        $this->assertFalse(property_exists($foo, 'none'));
    }

    /**
     * Test property is editable by setter when Object is dynamic.
     */
    public function test__setByGetter()
    {
        $foo = new Foo();
        $foo->setDynamic(true);
        $foo->bar = 'test';
        $this->assertAttributeSame('TEST', 'bar', $foo);
    }

    /**
     * Test property is directly editable when Object is dynamic.
     */
    public function test__setAllowed()
    {
        $foo = new Foo();
        $foo->setDynamic(true);
        $foo->none = 'none';
        $this->assertTrue(property_exists($foo, 'none'));
    }

    /**
     * Test dynamic methods logic.
     */
    public function test__call()
    {
        $foo = new Foo();
        $foo->addMethod(
            'bar',
            function ($arg) {
                return $this->bar . $arg;
            }
        );
        $this->assertSame('barb', $foo->bar('b'));
    }

    /**
     * Test dynamic methods logic with no method added.
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Try to call an undefined method: TRex\Core\resources\Foo::bar()
     */
    public function test__callWithoutAddedMethod()
    {
        $foo = new Foo();
        $this->assertNull($foo->bar('b'));
    }

    /**
     * Test hydration with an array.
     */
    public function test__constructWithArray()
    {
        $this->assertAttributeSame('TEST', 'bar', new Foo(['bar' => 'test']));
    }

    /**
     * Test hydration with a JSON.
     */
    public function test__constructWithJson()
    {
        $this->assertAttributeSame('TEST', 'bar', new Foo('{"bar": "test"}'));
    }

    /**
     * Test hydration with an Object.
     */
    public function test__constructWithAnObject()
    {
        $data = new \stdClass();
        $data->bar = 'test';
        $this->assertAttributeSame('TEST', 'bar', new Foo($data));
    }

    /**
     * Test hydration with non valid property name.
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Try to mutate an undefined property: TRex\Core\resources\Foo::none
     */
    public function test__constructWithAnNonValidPropertyName()
    {
        $this->assertObjectNotHasAttribute('none', new Foo(['none' => 'test']));
    }

    /**
     * Test hydration with non valid data.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $data must be a JSON, an array or an array castable object: integer given.
     */
    public function test__constructWithAnNonValidData()
    {
        $this->assertObjectNotHasAttribute('none', new Foo(123));
    }

    /**
     * Test simple array conversion.
     */
    public function testToArray()
    {
        $foo = new Foo();
        $this->assertSame(
            array(
                'foo' => 'foo from foo',
                'bar' => 'bar from bar'
            ),
            $foo->toArray()
        );
    }

    /**
     * Test simple JSON conversion.
     */
    public function testToJson()
    {
        $foo = new Foo();
        $result = $foo->toJson();
        $this->assertInstanceOf('TRex\Core\Json', $result);
        $this->assertSame(
            array(
                'foo' => 'foo from foo',
                'bar' => 'bar from bar'
            ),
            $result->toArray()
        );
    }
}
