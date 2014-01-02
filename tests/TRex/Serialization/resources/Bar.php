<?php
namespace TRex\Serialization\resources;

use TRex\Core\Object;

class Bar extends Object
{
    /**
     * @var string
     */
    private $foo = 'foo from bar';

    /**
     * @var string
     */
    private $bar = 'bar from bar';

    /**
     * Getter of $bar
     *
     * @return string
     */
    public function getBar()
    {
        return $this->bar;
    }

    /**
     * Getter of $foo
     *
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }
}
