# TRex\Core\Object

TRex\Core\Object is low level class which have to be extended.

## Dynamic object

### Prevent dynamic property

By default, PHP classes are dynamic with properties. You can add a property to an object, event if that property was not declared in the class. This causes a lot of confusion and is a source of bugs.

In using TRex\Core\Object, this behavior is canceled.

    class Foo extends TRex/Core/Object{}

    $foo = new Foo();
    $foo->none = 'none'; // exception is thrown

You can return to the initial behavior with Object::setIsDynamic()

    class Foo extends TRex/Core/Object{}

    $foo = new Foo();
    $foo->setIsDynamic(true);
    $foo->none = 'none';

### Allow dynamic method

By default, PHP classes are not dynamic with methods. you can not add a method to an object.

In using TRex\Core\Object, this behavior is allowed.

    class Foo extends TRex/Core/Object{
        private $a = 'a';
    }

    $foo = new Foo();
    $foo->addMethod('bar', function($arg){ return $this->a.$arg; });
    $foo->bar('b'); // 'ab'

Note that you have access to the context of the object into the function you pass.


## Object hydration

### From array

You can hydrate an object from an array.

    class Foo extends TRex/Core/Object{

    	private $a;

    	function getA(){
    		return $this->a;
    	}

    	function setA($a){
    		$this->a = a;
    	}

    }

    $foo = new Foo(["a" => 123]);
    echo $foo->getA(); //123

### From JSON

You can hydrate an object from a JSON string.

    class Foo extends TRex/Core/Object{

    	private $a;

    	function getA(){
    		return $this->a;
    	}

    	function setA($a){
    		$this->a = a;
    	}

    }

    $foo = new Foo('{"a": 123}');
    echo $foo->getA(); //123

### From object

You can hydrate an object from an array castable object.

    class Foo extends TRex/Core/Object{

    	private $a;

    	function getA(){
    		return $this->a;
    	}

    	function setA($a){
    		$this->a = a;
    	}

    }

    $data = new \stdClass();
    $data->a = 123;

    $foo = new Foo($data);
    echo $foo->getA(); //123


## Object export

Object export recovers its properties and transmits in a format independent of the object. By default, every property is exported, included protected and private one. In the same way, properties of parents are exported. If a parent property has the same name as a child, only the child's one is exported.

You can also hid some properties and prevent their exportation. You just have to specify it in the comment of these properties with the special tag @transient. This tag applies on all the properties of a class when it is added to the class comments.

You can also filter properties on their visibility (private/protected/public).

### To array

You can easily convert your object to JSON, choosing witch property you what to export with *@transient* comment tag, including private ones.

    class Foo extends TRex/Core/Object{

        private $a = 'a';

        /**
         * @transient
         */
        public $b = 'b';

    }

    $foo = new Foo();
    $foo->toArray(); //array (a: "a") => only non transient property

### To JSON

You can easily convert your object to JSON, choosing witch property you what to export with *@transient* comment tag, including private ones.

    class Foo extends TRex/Core/Object{

        private $a = 'a';

        /**
         * @transient
         */
        public $b = 'b';

    }

    echo new Foo(); //{a: "a"} => only non transient property

### To object

You can transform your object to an other object.

    class Bar{

        public $a;
        public $c;

    }

    class Foo extends TRex/Core/Object{

        private $a = 'a';

        /**
         * @cast \Bar::c
         */
        public $b = 'b';

    }

    $foo = new Foo();
    $bar = $foo->castTo('\Bar');
    echo $bar->$a; // null;
    echo $bar->$c; // 'b';
