# TRex\Core\Json

TRex\Core\Json is a JSON abstraction. You can convert Json into a JSON string or recover its data as array.


## Init

### From an array

    $data = array('a' => 'b');
    $json = new Json($data);

### From an object

    $data = new stdClass();
    $data->a = 'b';
    $json = new Json($data);

### From an IArrayCastable object

    $data = new myObject(array('a' => 'b'));
    $json = new Json($data);

### From a string

    $data = '{"a": "b"}';
    $json = Json::createFromString($data);


## Convert

### To an array

    $json->toArray(); //array('a' => 'b')

### To a string

    (string) $json; //"{"a": "b"}";
