<?php
namespace TRex\Parser;

/**
 * Class TokenizerTest
 * @package TRex\Parser
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TokenizerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClassNames()
    {
        $tokenizer = new Tokenizer(file_get_contents(__DIR__ . '/resources/tokenizerClasses.php'));
        $this->assertSame(array('Foo\class2', 'Foo\class3'), $tokenizer->getInstantiableClassNames());
    }
}
