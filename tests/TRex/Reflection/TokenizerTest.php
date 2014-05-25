<?php
namespace TRex\Reflection;

class TokenizerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClassNames()
    {
        $tokenizer = new Tokenizer(file_get_contents(__DIR__ . '/resources/tokenizerClasses.php'));
        $this->assertSame(array('class2', 'class3'), $tokenizer->getInstantiableClassNames());
    }
}
