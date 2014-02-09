# README

[![Build Status](https://travis-ci.org/Raphhh/trex.png?branch=Object-Reflection)](https://travis-ci.org/Raphhh/trex)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/trex/badges/quality-score.png?s=c5dc0874bf12e9c757c2f46a3439e91289bf07bc)](https://scrutinizer-ci.com/g/Raphhh/trex/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/trex/badges/coverage.png?s=ea0eee6ed113b03abd872b715217f554db09b647)](https://scrutinizer-ci.com/g/Raphhh/trex/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d52b1df3-646c-4d91-818c-8590d7a02150/mini.png)](https://insight.sensiolabs.com/projects/d52b1df3-646c-4d91-818c-8590d7a02150)

* [Website](http://labs.raphaellefebvre.be/trex/ "website")
* [User guide](http://labs.raphaellefebvre.be/trex/docs/master/ "doc")
* [API](http://labs.raphaellefebvre.be/trex/api/master/ "API")

## What is TRex?

TRex is a light toolbox with low level classes implemented with standard missing features.


## How to start?

### With Composer

You just have to add the TRex package in your composer.json and update your project.

```json
"require": {
    "raphhh/trex": "dev-master"
}
```

### Without Composer

The simplest way to start is to include the bootstrap file in your working file.

```php
include_once 'trex/src/TRex/boostrap.php';

//your code here
```


## What can I do?

In extending TRex, you have build-in features to use in your classes.

Some examples:


### Object hydration from JSON

You can hydrate an object from a JSON string.

```php
class Foo extends TRex/Core/Object{

    private $a;

    function getA(){
        return $this->a;
    }

    function setA($a){
        $this->a = a;
    }

}
```
```php
$foo = new Foo('{"a": 123}');
echo $foo->getA(); //123
```

### Object export in JSON

You can easily convert your object to JSON, choosing which property you want to export with *@transient* comment tag, including private ones.

```php
class Foo extends TRex/Core/Object{

    private $a = 'a';

    /**
     * @transient
     */
    public $b = 'b';

}
```
```php
echo new Foo(); //{a: "a"} => only non transient properties
```

### Composite action on several objects

You can list objects and call a same method on all of them.

```php
class Foo extends TRex/Core/Object{

    private $a = 'a';

    public getA(){
        return $this->a;
    }

    public setA($a){
        $this->a = $a;
    }

}
```
```php
//create some objects
$foo1 = new Foo();
$foo2 = new Foo();
```
```php
//getA() returns "a"
echo $foo1->getA(); //a
echo $foo2->getA(); //a
```
```php
//composite action sets "b" instead of "a"
(new Objects(array($foo1, $foo2)))->setA('b');
 ```
 ```php
//getA() returns "b", the value set by the composite action
echo $foo1->getA(); //b
echo $foo2->getA(); //b
```

### Memoization of method result

You can cache your method result without using a local property.
```php
class Foo extends TRex/Cache/CacheObject{

    private $a = 'a';

    public concat($arg){
        return $this->cache(function($arg){
            echo 'A lot of things...'
            return $this->a.$arg; //private context of your current object is still present.
        };
    }

}
```
```php
$foo = new Foo();

//first call, we execute the function
$result = $foo->concat('b'); // A lot of things...
echo $result; //ab
```
```php
//second call, nothing is written <= the function has not been called.
$result = $foo->concat('b');
echo $result; //ab
```
```php
//if we call the method with another argument, this is another cache.
$result = $foo->concat('c'); // A lot of things...
echo $result; //ac
```
```php
//but first cache is still pending.
$result = $foo->concat('b');
echo $result; //ab
```
