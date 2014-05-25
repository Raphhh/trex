<?php
namespace TRex\Parser;

/**
 * Class AnalyzerTest
 * @package TRex\Parser
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class AnalyzerTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetClassesFromFile()
    {
        $analyzer = new Analyzer();
        $result = $analyzer->getClassReflections(__DIR__ . '/resources/tokenizerClasses.php');
        $this->assertCount(2, $result);
        $this->assertSame('Foo\class2', $result['Foo\class2']->getName());
        $this->assertSame('Foo\class3', $result['Foo\class3']->getName());
    }
}
