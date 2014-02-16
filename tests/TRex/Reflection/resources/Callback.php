<?php
namespace TRex\Reflection\resources;

class Callback
{

    public static function bar($a, $b)
    {
        return func_get_args();
    }

    public function foo($a, $b)
    {
        return func_get_args();
    }

    public function __invoke($a, $b)
    {
        return func_get_args();
    }
}
