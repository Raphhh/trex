<?php
namespace TRex\Reflection;

/**
 * Class TypeReflectionTest
 * @package TRex\Reflection
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TypeReflectionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $typeReflection = new TypeReflection(__CLASS__);
        $this->assertSame(__CLASS__, $typeReflection->getType());
    }

    public function testGetTypeWithUpperCase()
    {
        $typeReflection = new TypeReflection('String');
        $this->assertSame(TypeReflection::STRING_TYPE, $typeReflection->getStandardizedType());
    }

    public function testGetTypeWithLowerCase()
    {
        $typeReflection = new TypeReflection('string');
        $this->assertSame(TypeReflection::STRING_TYPE, $typeReflection->getStandardizedType());
    }

    public function testGetTypeWithPartialName()
    {
        $typeReflection = new TypeReflection('bool');
        $this->assertSame(TypeReflection::BOOLEAN_TYPE, $typeReflection->getStandardizedType());
    }

    public function testGetTypeWithFullName()
    {
        $typeReflection = new TypeReflection('boolean');
        $this->assertSame(TypeReflection::BOOLEAN_TYPE, $typeReflection->getStandardizedType());
    }

    public function testGetStandardizedTypeWithClassName()
    {
        $typeReflection = new TypeReflection(__CLASS__);
        $this->assertSame(TypeReflection::OBJECT_TYPE, $typeReflection->getStandardizedType());
    }

    public function testGetStandardizedTypeWithClassNameList()
    {
        $typeReflection = new TypeReflection(__CLASS__ . '[]');
        $this->assertSame(TypeReflection::ARRAY_TYPE, $typeReflection->getStandardizedType());
    }

    public function testGetTypeWithUnknownType()
    {
        $typeReflection = new TypeReflection('none');
        $this->assertSame(TypeReflection::UNKNOWN_TYPE, $typeReflection->getStandardizedType());
    }

    public function testIsObjectWithType()
    {
        $typeReflection = new TypeReflection('object');
        $this->assertTrue($typeReflection->isObject());
    }

    public function testIsObjectWithClassName()
    {
        $typeReflection = new TypeReflection(__CLASS__);
        $this->assertTrue($typeReflection->isObject());
    }

    public function testIsObjectWithClassNameList()
    {
        $typeReflection = new TypeReflection(__CLASS__ . '[]');
        $this->assertFalse($typeReflection->isObject());
    }

    public function testIsObjectWithNull()
    {
        $typeReflection = new TypeReflection('null');
        $this->assertFalse($typeReflection->isObject());
    }

    public function testIsArrayWithType()
    {
        $typeReflection = new TypeReflection('array');
        $this->assertTrue($typeReflection->isArray());
    }

    public function testIsArrayWithClassNameList()
    {
        $typeReflection = new TypeReflection(__CLASS__ . '[]');
        $this->assertTrue($typeReflection->isArray());
    }

    public function testIsArrayCapitalized()
    {
        $typeReflection = new TypeReflection('Array');
        $this->assertTrue($typeReflection->isArray());
    }

    public function testIsVoid()
    {
        $typeReflection = new TypeReflection('void');
        $this->assertTrue($typeReflection->isVoid());
    }

    public function testIsMixed()
    {
        $typeReflection = new TypeReflection('mixed');
        $this->assertTrue($typeReflection->isMixed());
    }

    public function testIsNull()
    {
        $typeReflection = new TypeReflection('null');
        $this->assertTrue($typeReflection->isNull());
    }

    public function testIsNullCapitalized()
    {
        $typeReflection = new TypeReflection('NULL');
        $this->assertTrue($typeReflection->isNull());
    }

    public function testIsBooleanShort()
    {
        $typeReflection = new TypeReflection('bool');
        $this->assertTrue($typeReflection->isBoolean());
    }

    public function testIsBooleanLong()
    {
        $typeReflection = new TypeReflection('boolean');
        $this->assertTrue($typeReflection->isBoolean());
    }

    public function testIsString()
    {
        $typeReflection = new TypeReflection('string');
        $this->assertTrue($typeReflection->isString());
    }

    public function testIsIntegerShort()
    {
        $typeReflection = new TypeReflection('int');
        $this->assertTrue($typeReflection->isInteger());
    }

    public function testIsIntegerLong()
    {
        $typeReflection = new TypeReflection('integer');
        $this->assertTrue($typeReflection->isInteger());
    }

    public function testIsIntegerWithLong()
    {
        $typeReflection = new TypeReflection('long');
        $this->assertTrue($typeReflection->isInteger());
    }

    public function testIsFloat()
    {
        $typeReflection = new TypeReflection('float');
        $this->assertTrue($typeReflection->isFloat());
    }

    public function testIsFloatWithDouble()
    {
        $typeReflection = new TypeReflection('double');
        $this->assertTrue($typeReflection->isFloat());
    }

    public function testIsNumberWithInt()
    {
        $typeReflection = new TypeReflection('int');
        $this->assertTrue($typeReflection->isNumber());
    }

    public function testIsNumberWithInteger()
    {
        $typeReflection = new TypeReflection('integer');
        $this->assertTrue($typeReflection->isNumber());
    }

    public function testIsNumberWithLong()
    {
        $typeReflection = new TypeReflection('long');
        $this->assertTrue($typeReflection->isNumber());
    }

    public function testIsNumberWithFloat()
    {
        $typeReflection = new TypeReflection('float');
        $this->assertTrue($typeReflection->isNumber());
    }

    public function testIsNumberWithDouble()
    {
        $typeReflection = new TypeReflection('double');
        $this->assertTrue($typeReflection->isNumber());
    }

    public function testIsScalarWithString()
    {
        $typeReflection = new TypeReflection('string');
        $this->assertTrue($typeReflection->isScalar());
    }

    public function testIsScalarWithArray()
    {
        $typeReflection = new TypeReflection('array');
        $this->assertFalse($typeReflection->isScalar());
    }

    public function testIsResource()
    {
        $typeReflection = new TypeReflection('resource');
        $this->assertTrue($typeReflection->isResource());
    }
}
