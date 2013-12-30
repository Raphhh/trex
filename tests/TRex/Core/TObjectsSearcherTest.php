<?php
namespace TRex\Core;

/**
 * Class TObjectsSearcherTest
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TObjectsSearcherTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests has in strict mode with value.
     */
    public function testHasSimpleOk()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertTrue($objects->has(1));
    }

    /**
     * Tests has in strict mode with no value.
     */
    public function testHasSimpleKo()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertFalse($objects->has(2));
    }

    /**
     * Tests has in non strict mode with value.
     */
    public function testHasNonStrict()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertTrue($objects->has(2, IObjects::NON_STRICT_SEARCH_MODE));
    }

    /**
     * Tests has in regex mode with value.
     */
    public function testHasRegEx()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertTrue($objects->has('/[0-9]/', IObjects::REGEX_SEARCH_MODE));
    }

    /**
     * Tests search in strict mode with value.
     */
    public function testSearchSimpleOk()
    {
        $objects = new Objects(array(1, '1'));
        $this->assertSame(array(0), $objects->search(1));
    }

    /**
     * Tests search in strict mode with no value.
     */
    public function testSearchSimpleKo()
    {
        $objects = new Objects(array(1, '2'));
        $this->assertSame(array(), $objects->search(2));
    }

    /**
     * Tests search in non-strict mode with value.
     */
    public function testSearchNonStrict()
    {
        $objects = new Objects(array(1, '1'));
        $this->assertSame(array(0, 1), $objects->search(1, IObjects::NON_STRICT_SEARCH_MODE));
    }

    /**
     * Tests search in regex mode with value.
     */
    public function testSearchRegEx()
    {
        $objects = new Objects(array(1, '1'));
        $this->assertSame(array(0, 1), $objects->search('/[0-9]/', IObjects::REGEX_SEARCH_MODE));
    }
}
