<?php
namespace TRex\Reflection\resources;

/**
 * Class Foo
 * @package TRex\Reflection\resources
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
 