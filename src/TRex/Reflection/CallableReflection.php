<?php
namespace TRex\Reflection;

/**
 * Class CallableReflection
 * Callable Reflection: You can reflect a callback and know its type.
 * @package TRex\Reflection
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @todo has to be unit tested
 */
class CallableReflection
{
    /**
     * type const
     */
    const ERROR_TYPE = 0;
    const FUNCTION_TYPE = 1;
    const CLOSURE_TYPE = 2;
    const INSTANCE_METHOD_TYPE = 3;
    const STATIC_METHOD_TYPE = 4;
    const INVOKED_OBJECT_TYPE = 5;

    /**
     * reflected callback
     *
     * @var callable
     */
    private $callable;

    /**
     * type of the reflected callback (const XXX_TYPE)
     *
     * @var int
     */
    private $type;

    /**
     * initializes the reflected callback
     *
     * @param callable $callable
     */
    function __construct(callable $callable)
    {
        $this->setCallable($callable);
    }

    /**
     * getter of $callable
     *
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * invokes the reflected callback
     *
     * @return mixed
     */
    public function invoke()
    {
        return $this->invokeArgs(func_get_args());
    }

    /**
     * invokes the reflected callback
     *
     * @param array $args
     * @return mixed
     */
    public function invokeArgs(array $args)
    {
        return call_user_func_array($this->getCallable(), $args);
    }

    /**
     * invokes the reflected callback with static binding
     *
     * @return mixed
     */
    public function invokeStatic()
    {
        return $this->invokeArgsStatic(func_get_args());
    }

    /**
     * invokes the reflected callback with static binding
     *
     * @param array $args
     * @return mixed
     */
    public function invokeArgsStatic($args)
    {
        return forward_static_call_array($this->getCallable(), $args);
    }

    /**
     * getter of $type
     *
     * @return int
     */
    public function getType()
    {
        if (is_null($this->type)) {
            $this->initType();
        }
        return $this->type;
    }

    /**
     * indicates whether the callback is a function
     *
     * @return bool
     */
    public function isFunction()
    {
        return $this->getType() === self::FUNCTION_TYPE;
    }

    /**
     * indicates whether the callback is a Closure
     *
     * @return bool
     */
    public function isClosure()
    {
        return $this->getType() === self::CLOSURE_TYPE;
    }

    /**
     * indicates whether the callback is a method
     *
     * @return bool
     */
    public function isMethod()
    {
        return $this->isInstanceMethod() || $this->isStaticMethod();
    }

    /**
     * indicates whether the callback is a object method
     *
     * @return bool
     */
    public function isInstanceMethod()
    {
        return $this->getType() === self::INSTANCE_METHOD_TYPE;
    }

    /**
     * indicates whether the callback is a class method
     *
     * @return bool
     */
    public function isStaticMethod()
    {
        return $this->getType() === self::STATIC_METHOD_TYPE;
    }

    /**
     * indicates whether the callback is an invoked object
     *
     * @return bool
     */
    public function isInvokedObject()
    {
        return $this->getType() === self::INVOKED_OBJECT_TYPE;
    }

    /**
     * returns the name of the function, if the reflected callback is a function
     *
     * @return string
     */
    public function getFunctionName()
    {
        if ($this->isFunction()) {
            return $this->getCallable();
        }
        return '';
    }

    /**
     * returns the Closure object, if the reflected callback is a Closure
     *
     * @return \Closure|null
     */
    public function getClosure()
    {
        if ($this->isClosure()) {
            return $this->getCallable();
        }
        return null;
    }

    /**
     * returns the name of the method, if the reflected callback is a method (except __invoke)
     *
     * @return string
     */
    public function getMethodName()
    {
        if ($this->isMethod()) {
            $callable = $this->explodeCallable();
            return $callable[1];
        }
        return '';
    }

    /**
     * returns the name of the class, if the reflected callback is an object (except Closure)
     *
     * @return string
     */
    public function getClassName()
    {
        if ($this->isMethod() || $this->isInvokedObject()) {
            $callable = $this->explodeCallable();
            if ($this->isInstanceMethod() || $this->isInvokedObject()) {
                return get_class($callable[0]);
            }
            return $callable[0];
        }
        return '';
    }

    /**
     * returns the object, if the reflected callback is an object (except Closure)
     *
     * @return object|null
     */
    public function getObject()
    {
        if ($this->isInstanceMethod() || $this->isInvokedObject()) {
            $callable = $this->explodeCallable();
            return $callable[0];
        }
        return null;
    }

    /**
     * setter of $callable
     *
     * @param callable $callable
     */
    private function setCallable(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * explodes the reflected callback in an array and splits method/function from class/object
     *
     * @return array
     */
    private function explodeCallable()
    {
        if (is_string($this->getCallable())) {
            return explode('::', $this->getCallable());
        } elseif (is_array($this->getCallable())) {
            return $this->getCallable();
        } else {
            return array($this->getCallable());
        }
    }

    /**
     * setter of $type
     *
     * @param int $type
     */
    private function setType($type)
    {
        $this->type = (int)$type;
    }

    /**
     * initializes $type
     */
    private function initType()
    {
        if ($this->getCallable() instanceof \Closure) {
            $this->setType(self::CLOSURE_TYPE);

        } else {
            $callable = $this->explodeCallable();
            if (count($callable) === 1) {
                if (is_object($callable[0])) {
                    $this->setType(self::INVOKED_OBJECT_TYPE);

                } else {
                    $this->setType(self::FUNCTION_TYPE);
                }

            } elseif (count($callable) === 2) {
                if (is_object($callable[0])) {
                    $this->setType(self::INSTANCE_METHOD_TYPE);

                } else {
                    $this->setType(self::STATIC_METHOD_TYPE);
                }

            } else {
                $this->setType(self::ERROR_TYPE);
                trigger_error("Type not found for callable", E_USER_ERROR);
            }
        }
    }
}
