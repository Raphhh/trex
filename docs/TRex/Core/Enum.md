# TRex\Core\Enum

TRex\Core\Enum is an abstraction for a unique value in a finite list. This ensures you have a value among the constants of your class.


## How to implement?

First you need to declare all of possible values in the constants of your class.

    class Letter extends Enum{

        const A = 'a';
        const B = 'b';
        ...

    }

And when you instantiate your class, you have to specify one of this possible values.

    $a = new Letter(Letter::A);

    $a->getValue(); //'a'
    $a->is(Letter::A); //true

No other value is allowed.

    new Letter(123); //UnexpectedValueException
