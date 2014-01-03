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

    /**
     * @tag test
     * @var string|null comment with no sens
     */
    protected $bar = 'bar';

    private function getFoo()
    {
        return $this->foo;
    }

    /**
     * @tag test
     * @return null|string
     */
    private function getBar()
    {
        return $this->bar;
    }
}
