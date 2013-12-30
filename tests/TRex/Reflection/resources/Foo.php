<?php
namespace TRex\Reflection\resources;

/**
 * Class Foo
 * @package TRex\Reflection\resources
 * @transient
 */
class Foo extends Bar
{

    public $foo;

    protected $bar = 'bar';

    private function getFoo()
    {
    }

    private function getBar()
    {
    }
}
