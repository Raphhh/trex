# TRex\Core\Object

TRex\Core\Object is low level class which have to be extended.

## Dynamic object

### Prevent dynamic property

By default, PHP classes are dynamic with properties. You can add a property to an object, event if that property is not declared in the class. This causes a lot of confusion and is a source of bugs.

In using TRex\Core\Object, this behavior is canceled.

```php
class Foo extends TRex/Core/Object{}

$foo = new Foo();
$foo->none = 'none'; // exception is thrown
```

You can revert to the initial behavior with Object::setDynamic()

```php
class Foo extends TRex/Core/Object{}
```
```php
$foo = new Foo();
$foo->setDynamic(true);
$foo->none = 'none';
```

### Allow dynamic method

By default, PHP classes have not dynamic methods. You can not add a method to an object.

In using TRex\Core\Object, this behavior is allowed.

```php
class Foo extends TRex/Core/Object{
    private $a = 'a';
}
```
```php
$foo = new Foo();
$foo->addMethod('bar', function($arg){ return $this->a.$arg; });
$foo->bar('b'); // 'ab'
```

Note that you have access to the context of the current object ($this) in the function you pass.


## Object hydration

### From array

You can hydrate an object from an array.

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
$foo = new Foo(["a" => 123]);
echo $foo->getA(); //123
```

### From JSON

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

### From object

You can hydrate an object from an array castable object.

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
$data = new \stdClass();
$data->a = 123;
```
```php
$foo = new Foo($data);
echo $foo->getA(); //123
```


## Object export

Object export recovers its properties and transmits in a format independent of the object. By default, every property is exported, included protected and private one. In the same way, properties of parents are exported. If a parent property has the same name as a child, only the child's one is exported.

You can also hide some properties and prevent their exportation. You just have to specify it in the comment of these properties with the special tag @transient. This tag applies on all the properties of a class when it is added to the class comments.

You can also filter properties on their visibility (private/protected/public).

### To array

You can easily convert your object to JSON, choosing which property you what to export with *@transient* comment tag, including private ones.

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
$foo = new Foo();
$foo->toArray(); //array (a: "a") => only non transient property
```

### To JSON

You can easily convert your object to JSON, choosing which property you what to export with *@transient* comment tag, including private ones.

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
echo new Foo(); //{a: "a"} => only non transient property
```

### To any other object

You can transform your object to an other object.

```php
class Bar{

    public $a;
    public $c;

}
```
```php
class Foo extends TRex/Core/Object{

    private $a = 'a';

    /**
     * @cast \Bar::c
     */
    public $b = 'b';

}
```
```php
$foo = new Foo();
$bar = $foo->castTo('\Bar');
echo $bar->a; // null;
echo $bar->c; // 'b';
```