<?php
namespace TRex\Reflection;

use TRex\Reflection\resources\Callback;

class CallableReflectionTest extends \PHPUnit_Framework_TestCase
{

    public function testGetCallable()
    {
        $callable = $this->getInvokedObject();
        $reflectedCallable = new CallableReflection($callable);
        $this->assertSame($callable, $reflectedCallable->getCallable());
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
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertSame(CallableReflection::FUNCTION_TYPE, $reflectedCallable->getType());
    }

    public function testGetTypeForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame(CallableReflection::CLOSURE_TYPE, $reflectedCallable->getType());
    }

    public function testGetTypeForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(CallableReflection::INSTANCE_METHOD_TYPE, $reflectedCallable->getType());
    }

    public function testGetTypeForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame(CallableReflection::STATIC_METHOD_TYPE, $reflectedCallable->getType());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame(CallableReflection::STATIC_METHOD_TYPE, $reflectedCallable->getType());
    }

    public function testGetTypeForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame(CallableReflection::INVOKED_OBJECT_TYPE, $reflectedCallable->getType());
    }

    //... todo isType

    public function testGetFunctionNameForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertSame($this->getFunction(), $reflectedCallable->getFunctionName());
    }

    public function testGetFunctionNameForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame('', $reflectedCallable->getFunctionName());
    }

    public function testGetFunctionNameForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame('', $reflectedCallable->getFunctionName());
    }

    public function testGetFunctionNameForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame('', $reflectedCallable->getFunctionName());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame('', $reflectedCallable->getFunctionName());
    }

    public function testGetFunctionNameForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame('', $reflectedCallable->getFunctionName());
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
