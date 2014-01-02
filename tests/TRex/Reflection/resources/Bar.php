<?php
namespace TRex\Reflection\resources;

/**
 * Class Bar
 * @package TRex\Reflection\resources
 */
class Bar
{
    /**
     * @transient
     */
    private $foo;

    private $bar;

    private function getFoo()
    {
        return $this->foo;
    }

    private function getBar()
    {
        return $this->bar;
    }
}
