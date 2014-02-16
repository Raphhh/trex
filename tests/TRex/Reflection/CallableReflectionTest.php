<?php
namespace TRex\Reflection;

use TRex\Reflection\resources\Callback;

class CallableReflectionTest extends \PHPUnit_Framework_TestCase
{

    public function testCallable()
    {
    }

    public function testGetReflectionForFunction()
    {
    }

    public function testGetReflectionForClosure()
    {
    }

    public function testGetReflectionForInstanceMethod()
    {
    }

    public function testGetReflectionForStaticMethod()
    {
    }

    public function testGetReflectionForInvokedObject()
    {
    }

    public function testInvokeForFunction()
    {
    }

    public function testInvokeForClosure()
    {
    }

    public function testInvokeForInstanceMethod()
    {
    }

    public function testInvokeForStaticMethod()
    {
    }

    public function testInvokeForInvokedObject()
    {
    }

    public function testInvokeArgsForFunction()
    {
    }

    public function testInvokeArgsForClosure()
    {
    }

    public function testInvokeArgsForInstanceMethod()
    {
    }

    public function testInvokeArgsForStaticMethod()
    {
    }

    public function testInvokeArgsForInvokedObject()
    {
    }

    public function testInvokeAForFunction()
    {
    }

    public function testInvokeAForClosure()
    {
    }

    public function testInvokeAForInstanceMethod()
    {
    }

    public function testInvokeAForStaticMethod()
    {
    }

    public function testInvokeAForInvokedObject()
    {
    }

    public function testInvokeStaticForFunction()
    {
    }

    public function testInvokeStaticForClosure()
    {
    }

    public function testInvokeStaticForInstanceMethod()
    {
    }

    public function testInvokeStaticForStaticMethod()
    {
    }

    public function testInvokeStaticForInvokedObject()
    {
    }

    public function testInvokeArgsStaticForFunction()
    {
    }

    public function testInvokeArgsStaticForClosure()
    {
    }

    public function testInvokeArgsStaticForInstanceMethod()
    {
    }

    public function testInvokeArgsStaticForStaticMethod()
    {
    }

    public function testInvokeArgsStaticForInvokedObject()
    {
    }

    public function testInvokeAStaticForFunction()
    {
    }

    public function testInvokeAStaticForClosure()
    {
    }

    public function testInvokeAStaticForInstanceMethod()
    {
    }

    public function testInvokeAStaticForStaticMethod()
    {
    }

    public function testInvokeAStaticForInvokedObject()
    {
    }

    public function testGetTypeForFunction()
    {
    }

    public function testGetTypeForClosure()
    {
    }

    public function testGetTypeForInstanceMethod()
    {
    }

    public function testGetTypeForStaticMethod()
    {
    }

    public function testGetTypeForInvokedObject()
    {
    }

    //... todo isType

    public function testGetFunctionNameForFunction()
    {
    }

    public function testGetFunctionNameForClosure()
    {
    }

    public function testGetFunctionNameForInstanceMethod()
    {
    }

    public function testGetFunctionNameForStaticMethod()
    {
    }

    public function testGetFunctionNameForInvokedObject()
    {
    }

    public function testGetClosureForFunction()
    {
    }

    public function testGetClosureForClosure()
    {
    }

    public function testGetClosureForInstanceMethod()
    {
    }

    public function testGetClosureForStaticMethod()
    {
    }

    public function testGetClosureForInvokedObject()
    {
    }

    public function testGetMethodNameForFunction()
    {
    }

    public function testGetMethodNameForClosure()
    {
    }

    public function testGetMethodNameForInstanceMethod()
    {
    }

    public function testGetMethodNameForStaticMethod()
    {
    }

    public function testGetMethodNameForInvokedObject()
    {
    }

    public function testGetClassNameForFunction()
    {
    }

    public function testGetClassNameForClosure()
    {
    }

    public function testGetClassNameForInstanceMethod()
    {
    }

    public function testGetClassNameForStaticMethod()
    {
    }

    public function testGetClassNameForInvokedObject()
    {
    }

    public function testGetObjectForFunction()
    {
    }

    public function testGetObjectForClosure()
    {
    }

    public function testGetObjectForInstanceMethod()
    {
    }

    public function testGetObjectForStaticMethod()
    {
    }

    public function testGetObjectForInvokedObject()
    {
    }

    /**
     * @return callable
     */
    private function getFunction()
    {
        return 'is_string';
    }

    /**
     * @return callable
     */
    private function getClosure()
    {
        return function ($a, $b) {
            return func_get_args();
        };
    }

    /**
     * @return callable
     */
    private function getInstanceMethod()
    {
        $callback = new Callback();
        return array($callback, 'foo');
    }

    /**
     * @return callable
     */
    private function getStaticMethod1()
    {
        return array('TRex\Reflection\resources\Callback', 'bar');
    }

    /**
     * @return callable
     */
    private function getStaticMethod2()
    {
        return 'TRex\Reflection\resources\Callback::bar';
    }

    /**
     * @return callable
     */
    private function getInvokedObject()
    {
        return new Callback();
    }
}
