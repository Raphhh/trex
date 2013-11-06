<?php
namespace TRexTests\Core\resources;

use TRex\Core\Object;

/**
 * Class Foo
 * @package TRexTests\Core\resources
 */
class Foo extends Object
{

    /**
     * @var string
     */
    private $bar = 'bar';

    /**
     * @param string $bar
     */
    public function setBar($bar)
    {
        $this->bar = strtoupper($bar);
    }

    /**
     * @return string
     */
    public function getBar()
    {
        return strtoupper($this->bar);
    }
}
