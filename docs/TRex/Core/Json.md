# TRex\Core\Json

TRex\Core\Json is a JSON abstraction. You can convert Json into a JSON string or recover its data as array.


## Init

### From an array

```php
$data = array('a' => 'b');
$json = new Json($data);
```

### From an object

```php
$data = new stdClass();
$data->a = 'b';
$json = new Json($data);
```

### From an IArrayCastable object

```php
$data = new myObject(array('a' => 'b'));
$json = new Json($data);
```

### From a string

```php
$data = '{"a": "b"}';
$json = new Json($data);
```


## Convert

### To an array

```php
$json->toArray(); //array('a' => 'b')
```

### To a string

```php
(string) $json; //"{"a": "b"}";
```