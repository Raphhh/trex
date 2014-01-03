<?php
namespace TRex\Annotation;

/**
 * Class AnnotationParserTest
 * @package TRex\Annotation
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class AnnotationParserTest extends \PHPUnit_Framework_TestCase
{

    public function testGetAnnotationsType()
    {
        $annotationParser = new AnnotationParser();
        $this->assertInstanceOf('TRex\Annotation\Annotations', $annotationParser->getAnnotations(''));
    }

    public function testGetAnnotationsEmpty()
    {
        $annotationParser = new AnnotationParser();
        $this->assertCount(0, $annotationParser->getAnnotations(''));
    }

    public function testGetAnnotationsFull()
    {
        $docComment = '/**
						* comment..
						*
						* @param string $param1
						* @param int $param2
						* @return mixed
						*/';

        $annotationParser = new AnnotationParser();
        $annotations = $annotationParser->getAnnotations($docComment);
        $this->assertCount(2, $annotations);

        //@param
        $this->assertInstanceOf('TRex\Annotation\Annotation', $annotations['param']);
        $this->assertCount(2, $annotations['param']);
        $this->assertSame('string $param1', $annotations['param'][0]);
        $this->assertSame('int $param2', $annotations['param'][1]);

        //@return
        $this->assertInstanceOf('TRex\Annotation\Annotation', $annotations['return']);
        $this->assertCount(1, $annotations['return']);
        $this->assertSame('mixed', $annotations['return'][0]);
    }

    public function testParseTypeComment()
    {
        $annotationParser = new AnnotationParser();
        $types = $annotationParser->parseTypeComment('null|\Vendor\Package\Class[] my cspecial comment');
        $this->assertCount(2, $types);
        $this->assertSame('null', $types[0]);
        $this->assertSame('\Vendor\Package\Class[]', $types[1]);
    }
}
