<?php
namespace TRexTests\Reflection\resources;

/**
 * Class Foo
 * @package TRexTests\Reflection\resources
 * @transient
 */
class Foo extends Bar
{

    /**
     * @transient
     */
    public $foo;

    protected $bar = 'bar';

    /**
     * @transient
     */
    private function getFoo()
    {
    }

    private function getBar()
    {
    }
}
 