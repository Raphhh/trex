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
     * @var mixed
     * @return int
     */
    protected $bar = 'bar';

    private function getFoo()
    {
        return $this->foo;
    }

    /**
     * @tag test
     * @return string|null  comment with no sens
     * @return mixed
     * @var int
     */
    private function getBar()
    {
        return $this->bar;
    }
}
