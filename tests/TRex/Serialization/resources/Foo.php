<?php
namespace TRex\Serialization\resources;

class Foo extends Bar
{
    /**
     * @var string
     * @transient
     */
    public $foo = 'foo from foo';
    public $bar = 'bar from foo';
}
