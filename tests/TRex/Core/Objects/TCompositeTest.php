<?php
namespace TRex\Core;

/**
 * Class TCompositeTest
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TCompositeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests the modification of internal objects.
     */
    public function testInvoke()
    {
        $objects = new Objects();
        $objects[0] = new resources\foo();
        $objects[1] = new resources\foo();

        $objects->invoke('setFoo', array('foo is setted'));

        foreach ($objects as $object) {
            /**
             * @var resources\foo $object
             */
            $this->assertSame('foo is setted', $object->getFoo());
        }
    }

    /**
     * Tests the recovery of internal objects value.
     */
    public function testInvokeResult()
    {
        $objects = new Objects();
        $objects[0] = new resources\foo();
        $objects[1] = new resources\foo();

        $this->assertSame(array('foo from foo', 'foo from foo'), $objects->invoke('getFoo'));
    }
}
