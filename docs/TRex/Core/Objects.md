# TRex\Core\Objects

TRex\Core\Object is a powerful array object. He handles a list like an object.


## TRex\Core\Object behavior

Objects extends TRex\Core\Object and inherits of all its behavior.

## Hydration

For example, like for Object, you can hydrate Objects from an array or a JSON:

    new Objects(array('dino' => 't-rex'));

## Export

Other example, you can export Objects into an array.

    $objects = new Objects(array('dino' => 't-rex'));
    $objects->toArray(); //array('dino' => 't-rex')


## Array behavior

Objects can be handled like an array.

### Access to value

    $objects = new Objects();
    $objects[] = 't-rex';
    $objects[0]; //t-rex

### Loop

    foreach ($objects as $key => $value) {
       $key . ' => ' . $value; // 0 => t-rex
    }

### Count

    count($objects); //1


## Object behavior

Objects can be handled like an object. The main native functions for array can be used with Objects, but in a oriented object behavior.

### Getter

Get current value:

    $objects = new Objects();
    $objects['dino'] = 't-rex';

    $objects->current(); // t-rex

Find a value from its key:

    $objects = new Objects();
    $objects[] = 't-rex';

    $objects->get(0); //t-rex

Find a value from its index, regardless of the key:

    $objects = new Objects();
    $objects['dino'] = 't-rex';

    $objects->get(0); //t-rex

Find the first value:

    $objects = new Objects();
    $objects['dino'] = 't-rex';
    $objects['pet'] = 'dog';

    $objects->getFirst(); //t-rex

Find the last value:

    $objects = new Objects();
    $objects['dino'] = 't-rex';
    $objects['pet'] = 'dog';

    $objects->getLast(); //dog


### Searcher

Know if a value is present:

    $objects = new Objects();
    $objects['dino'] = 't-rex';

    $object->has('t-rex'); //true

With a reg-ex:

    $objects = new Objects();
    $objects['dino'] = 't-rex';

    $object->has('/t-/', IObjects::REGEX_SEARCH_MODE); //true

Find the keys associated for a value:

    $objects = new Objects();
    $objects[0] = 't-rex';
    $objects[1] = 't-rex';
    $objects[2] = 'dog';

    $objects->search('t-rex'); //array(0, 1)

With a reg-ex:

    $objects = new Objects();
    $objects[0] = 't-rex';
    $objects[1] = 't-rex';
    $objects[2] = 'dog';

    $objects->search('/t-/', IObjects::REGEX_SEARCH_MODE); //array(0, 1)

Know if a key exists:

    $objects = new Objects();
    $objects['dino'] = 't-rex';

    $objects->exist('dino'); //true


### Key accessor

Get current key:

    $objects = new Objects();
    $objects['dino'] = 't-rex';

    $objects->key(); //dino

Find an associated key from an index:

    $objects = new Objects();
    $objects['dino'] = 't-rex';

    $objects->getKey(0); //dino

Find the first key:

    $objects = new Objects();
    $objects['dino'] = 't-rex';
    $objects['pet'] = 'dog';

    $objects->getFirstKey(); //dino

Find the last key:

    $objects = new Objects();
    $objects['dino'] = 't-rex';
    $objects['pet'] = 'dog';

    $objects->getLastKey(); //pet


### Handle pointer

Get next key:

    $objects = new Objects();
    $objects['dino'] = 't-rex';
    $objects['pet'] = 'dog';

    $objects->next(); //pet

Objects::seek() and Objects::rewind() can move pointer to a specific position or to the beginning of the list.


### Adder

Add a value at a specific key:

    $objects = new Objects();
    $objects->addAt(10, 't-rex');

Add a value at first:

    $objects = new Objects();
    $objects->addFirst('t-rex');

Add a value at last:

    $objects = new Objects();
    $objects->addLast('t-rex');


### Remover

Remove a value at a specific key:

    $objects = new Objects();
    $objects[10] = 't-rex';

    $objects->removeAt(10); //t-rex unseted

Remove the first value:

    $objects = new Objects();
    $objects[0] = 't-rex';
    $objects[1] = 'dog';

    $objects->removeFirst(); //t-rex unseted

Remove the last value:

    $objects = new Objects();
    $objects[0] = 't-rex';
    $objects[1] = 'dog';

    $objects->removeLast(); //dog unseted


### Sorter

Reindex the keys:

    $objects = new Objects();
    $objects['dino'] = 't-rex';
    $objects['pet'] = 'dog';

    $newObjects = $objects->reindex();
    $newObjects->toArray(); //array(0 => 't-rex', 1 => 'dog')

Sort by value ASC:

    $objects = new Objects();
    $objects['dino'] = 't-rex';
    $objects['pet'] = 'dog';

    $newObjects = $objects->sort();
    $newObjects->toArray(); //array('pet' => 'dog', 'dino' => 't-rex')

Sort by value DESC:

    $objects = new Objects();
    $objects['pet'] = 'dog';
    $objects['dino'] = 't-rex';

    $newObjects = $objects->sort(new SortType(SortType::VALUE_SORT_TYPE), SORT_DESC);
    $newObjects->toArray(); //array('dino' => 't-rex', 'pet' => 'dog')


Sort by key ASC:

    $objects = new Objects();
    $objects['pet'] = 'dog';
    $objects['dino'] = 't-rex';

    $newObjects = $objects->sort(new SortType(SortType::KEY_SORT_TYPE));
    $newObjects->toArray(); //array('dino' => 't-rex', 'pet' => 'dog')

Sort by key DESC:

    $objects = new Objects();
    $objects['dino'] = 't-rex';
    $objects['pet'] = 'dog';

    $newObjects = $objects->sort(new SortType(SortType::KEY_SORT_TYPE), SORT_DESC);
    $newObjects->toArray(); //array('pet' => 'dog', 'dino' => 't-rex')

Sort with a callback:

    $objects = new Objects();
    $objects['dino'] = 't-rex';
    $objects['pet'] = 'dog';

    $newObjects = $objects->sort(new SortType(SortType::ASSOCIATIVE_SORT_TYPE), $callback);


### Modifier

Extract a part of the list:

    $objects = new Objects();
    $objects[0] = 't-rex';
    $objects[1] = 'dog';
    $objects[2] = 'cat';

    $newObjects = $objects->extract(1);
    $newObjects->toArray(); //array(1 => 'dog', 2 => 'cat')

Apply a callback to the values:

    $objects = new Objects();
    $objects[0] = 't-rex';
    $objects[1] = 'dog';
    $objects[2] = 'cat';

    $newObjects = $objects->each(function($value){ return strtoupper($value); });
    $newObjects->toArray(); //array('T-REX', 'DOG', 'CAT')

Filter values with a callback:

    $objects = new Objects();
    $objects[0] = 't-rex';
    $objects[1] = 'dog';
    $objects[2] = 'cat';

    $newObjects = $objects->each(function($value){ return $value==='dog'; });
    $newObjects->toArray(); //array(1 => 'dog')


### Comparator

Merge any objects:

    $objects_1 = new Objects();
    $objects_1[0] = 't-rex';

    $objects_2 = new Objects();
    $objects_2[0] = 'dog';

    $objects_3 = new Objects();
    $objects_3[0] = 'cat';

    $newObjects = $objects_1->merge($objects_2, $objects_3);
    $newObjects->toArray(); //array(0 => 't-rex', 1 => 'dog', 2 => 'cat')

Find the difference between any objects:

    $objects_1 = new Objects();
    $objects_1[0] = 't-rex';
    $objects_1[1] = 'dog';
    $objects_1[2] = 'cat';

    $objects_2 = new Objects();
    $objects_2[0] = 'dog';

    $objects_3 = new Objects();
    $objects_3[0] = 'cat';

    $newObjects = $objects_1->intersect($objects_2, $objects_3);
    $newObjects->toArray(); //array('t-rex')

Find intersection between any Objects:

    $objects_1 = new Objects();
    $objects_1[0] = 't-rex';

    $objects_2 = new Objects();
    $objects_2[0] = 't-rex';
    $objects_2[0] = 'dog';

    $objects_3 = new Objects();
    $objects_2[0] = 't-rex';
    $objects_3[0] = 'cat';

    $newObjects = $objects_1->intersect($objects_2, $objects_3);
    $newObjects->toArray(); //array('t-rex')


#### Composite behavior

You can list objects and call a same method on all of them:

    class Foo extends TRex/Core/Object{

        private $a = 'a';

        public getA(){
            return $this->a;
        }

        public setA($a){
            $this->a = $a;
        }

    }

    //create some objects
    $foo1 = new Foo();
    $foo2 = new Foo();

    //getA() return "a"
    echo $foo1->getA(); //a
    echo $foo2->getA(); //a

    //composite action set "b" instead of "a"
    (new Objects(array($foo1, $foo2)))->setA('b');

    //getA() return "b", the value setted by the composite action
    echo $foo1->getA(); //b
    echo $foo2->getA(); //b