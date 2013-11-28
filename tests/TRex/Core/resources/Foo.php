<?php
namespace TRex\Core\resources;

/**
 * Class Foo
 * @package TRex\Core\resources
 */
class Foo extends Bar
{

    /**
     * @transient
     * @var string
     */
    private $bar = 'bar';

    /**
     * @var string
     */
    private $foo = 'foo from foo';

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

    /**
     * Setter of $foo.
     *
     * @param string $foo
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;
    }

    /**
     * Getter of $foo.
     *
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }
}
