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
        $reflectedCallable = new CallableReflection($this->getFunction());
        $reflection = $reflectedCallable->getReflection();
        $this->assertInstanceOf('\ReflectionFunction', $reflection);
        $this->assertSame($this->getFunction(), $reflection->getName());
    }

    public function testGetReflectionForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $reflection = $reflectedCallable->getReflection();
        $this->assertInstanceOf('\ReflectionFunction', $reflection);
        $this->assertSame('TRex\Reflection\{closure}', $reflection->getName());
    }

    public function testGetReflectionForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $reflection = $reflectedCallable->getReflection();
        $this->assertInstanceOf('\ReflectionMethod', $reflection);
        $this->assertSame('foo', $reflection->getName());
    }

    public function testGetReflectionForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $reflection = $reflectedCallable->getReflection();
        $this->assertInstanceOf('\ReflectionMethod', $reflection);
        $this->assertSame('bar', $reflection->getName());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $reflection = $reflectedCallable->getReflection();
        $this->assertInstanceOf('\ReflectionMethod', $reflection);
        $this->assertSame('bar', $reflection->getName());
    }

    public function testGetReflectionForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $reflection = $reflectedCallable->getReflection();
        $this->assertInstanceOf('\ReflectionMethod', $reflection);
        $this->assertSame('__invoke', $reflection->getName());
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

    public function testIsFunctionForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertTrue($reflectedCallable->isFunction());
    }

    public function testIsFunctionForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertFalse($reflectedCallable->isFunction());
    }

    public function testIsFunctionForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertFalse($reflectedCallable->isFunction());
    }

    public function testIsFunctionForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertFalse($reflectedCallable->isFunction());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertFalse($reflectedCallable->isFunction());
    }

    public function testIsFunctionForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertFalse($reflectedCallable->isFunction());
    }

    public function testIsClosureForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertFalse($reflectedCallable->isClosure());
    }

    public function testIsClosureForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertTrue($reflectedCallable->isClosure());
    }

    public function testIsClosureForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertFalse($reflectedCallable->isClosure());
    }

    public function testIsClosureForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertFalse($reflectedCallable->isClosure());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertFalse($reflectedCallable->isClosure());
    }

    public function testIsClosureForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertFalse($reflectedCallable->isClosure());
    }

    public function testIsInstanceMethodForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertFalse($reflectedCallable->isInstanceMethod());
    }

    public function testIsInstanceMethodForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertFalse($reflectedCallable->isInstanceMethod());
    }

    public function testIsInstanceMethodForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertTrue($reflectedCallable->isInstanceMethod());
    }

    public function testIsInstanceMethodForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertFalse($reflectedCallable->isInstanceMethod());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertFalse($reflectedCallable->isInstanceMethod());
    }

    public function testIsInstanceMethodForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertFalse($reflectedCallable->isInstanceMethod());
    }

    public function testIsStaticMethodForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertFalse($reflectedCallable->isStaticMethod());
    }

    public function testIsStaticMethodForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertFalse($reflectedCallable->isStaticMethod());
    }

    public function testIsStaticMethodForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertFalse($reflectedCallable->isStaticMethod());
    }

    public function testIsStaticMethodForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertTrue($reflectedCallable->isStaticMethod());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertTrue($reflectedCallable->isStaticMethod());
    }

    public function testIsStaticMethodForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertFalse($reflectedCallable->isStaticMethod());
    }

    public function testIsInvokedObjectForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertFalse($reflectedCallable->isInvokedObject());
    }

    public function testIsInvokedObjectForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertFalse($reflectedCallable->isInvokedObject());
    }

    public function testIsInvokedObjectForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertFalse($reflectedCallable->isInvokedObject());
    }

    public function testIsInvokedObjectForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertFalse($reflectedCallable->isInvokedObject());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertFalse($reflectedCallable->isInvokedObject());
    }

    public function testIsInvokedObjectForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertTrue($reflectedCallable->isInvokedObject());
    }

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
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertNull($reflectedCallable->getClosure());
    }

    public function testGetClosureForClosure()
    {
        $closure = $this->getClosure();
        $reflectedCallable = new CallableReflection($closure);
        $this->assertSame($closure, $reflectedCallable->getClosure());
    }

    public function testGetClosureForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertNull($reflectedCallable->getClosure());
    }

    public function testGetClosureForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertNull($reflectedCallable->getClosure());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertNull($reflectedCallable->getClosure());
    }

    public function testGetClosureForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertNull($reflectedCallable->getClosure());
    }

    public function testGetMethodNameForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertSame('', $reflectedCallable->getMethodName());
    }

    public function testGetMethodNameForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame('', $reflectedCallable->getMethodName());
    }

    public function testGetMethodNameForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame('foo', $reflectedCallable->getMethodName());
    }

    public function testGetMethodNameForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame('bar', $reflectedCallable->getMethodName());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame('bar', $reflectedCallable->getMethodName());
    }

    public function testGetMethodNameForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame('', $reflectedCallable->getMethodName());
    }

    public function testGetClassNameForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertSame('', $reflectedCallable->getClassName());
    }

    public function testGetClassNameForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame('', $reflectedCallable->getClassName());
    }

    public function testGetClassNameForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame('TRex\Reflection\resources\Callback', $reflectedCallable->getClassName());
    }

    public function testGetClassNameForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame('TRex\Reflection\resources\Callback', $reflectedCallable->getClassName());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame('TRex\Reflection\resources\Callback', $reflectedCallable->getClassName());
    }

    public function testGetClassNameForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame('TRex\Reflection\resources\Callback', $reflectedCallable->getClassName());
    }

    public function testGetObjectForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertNull($reflectedCallable->getObject());
    }

    public function testGetObjectForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertNull($reflectedCallable->getObject());
    }

    public function testGetObjectForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertInstanceOf('TRex\Reflection\resources\Callback', $reflectedCallable->getObject());
    }

    public function testGetObjectForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertNull($reflectedCallable->getObject());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertNull($reflectedCallable->getObject());
    }

    public function testGetObjectForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertInstanceOf('TRex\Reflection\resources\Callback', $reflectedCallable->getObject());
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
