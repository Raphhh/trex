<?php
namespace TRex\Core;

/**
 * Class JsonTest
 * class test for Json
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class JsonTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Extends Object
     */
    public function testInheritance()
    {
        $data = array("bar" => "test");
        $this->assertInstanceOf('TRex\Core\Object', new Json($data));
    }

    /**
     * Tests createFromString
     */
    public function testCreateFromString()
    {
        $result = Json::createFromString('{"bar": "test"}');
        $this->assertInstanceOf('TRex\Core\Json', $result);
        $this->assertSame(["bar" => "test"], $result->toArray());
    }

    /**
     * Tests createFromString when the value is not a json object.
     *
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage JSON string can not be decoded: "1" (Error: #0 - No errors)
     */
    public function testCreateFromStringWithException()
    {
        $this->assertNull(Json::createFromString('1'));
    }

    /**
     * Tests toArray.
     */
    public function testToArray()
    {
        $data = array("bar" => "test");
        $json = new Json($data);
        $this->assertSame($data, $json->toArray());
    }

    /**
     * Tests options setter and getter.
     */
    public function testGetOptions()
    {
        $data = array("bar" => "test");
        $json = new Json($data);
        $json->setOptions(JSON_PRETTY_PRINT);
        $this->assertSame(JSON_PRETTY_PRINT, $json->getOptions());
    }

    /**
     * Tests options default value.
     */
    public function testGetOptionsDefault()
    {
        $data = array("bar" => "test");
        $json = new Json($data);
        $this->assertSame(0, $json->getOptions());
    }

    /**
     * Tests string conversion.
     */
    public function test__toString()
    {
        $data = array("bar" => "test");
        $json = new Json($data);
        $json->setOptions(JSON_PRETTY_PRINT);
        $this->assertSame(json_encode($data, JSON_PRETTY_PRINT), (string)$json);
    }

    /**
     * Tests getErrorMessage.
     */
    public function testGetErrorMessage()
    {
        $errors = array(
            JSON_ERROR_NONE => 'No errors',
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded',
            999999999 => 'Unknown error'
        );
        foreach ($errors as $no => $message) {
            $this->assertSame($message, Json::getErrorMessage($no));
        }
    }
}
