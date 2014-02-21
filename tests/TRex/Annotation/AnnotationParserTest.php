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

    /**
     * @dataProvider provideDocComment
     * @param $docComment
     */
    public function testGetAnnotationsFull($docComment)
    {
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

    public function provideDocComment()
    {
        return array(
            array( //with spaces
                'docComment' => '/**
                    * comment..
                    *
                    * @param string $param1
                    * @param int $param2
                    * @return mixed
                    */',
            ),
            array( //with double spaces
                'docComment' => '/**
                    * comment..
                    *
                    * @param  string $param1
                    * @param  int $param2
                    * @return  mixed
                    */',
            ),
            array( //with tabs
                'docComment' => '/**
                    * comment..
                    *
                    * @param	string $param1
                    * @param	int $param2
                    * @return	mixed
                    */',
            ),
        );
    }

    /**
     * @dataProvider provideTypeComment
     * @param $typeComment
     */
    public function testParseTypeComment($typeComment)
    {
        $annotationParser = new AnnotationParser();
        $types = $annotationParser->parseTypeComment($typeComment);
        $this->assertCount(2, $types);
        $this->assertSame('null', $types[0]);
        $this->assertSame('\Vendor\Package\Class[]', $types[1]);
    }

    public function provideTypeComment()
    {
        return array(
            array( //with spaces
                'typeComment' => 'null|\Vendor\Package\Class[] my special comment',
            ),
            array( //with double spaces
                'typeComment' => 'null|\Vendor\Package\Class[]  my special comment',
            ),
            array( //with tabs
                'typeComment' => 'null|\Vendor\Package\Class[]	my special comment',
            ),
        );
    }

    /**
     * Tests parseTypeComment with empty string.
     */
    public function testParseTypeCommentEmpty()
    {
        $annotationParser = new AnnotationParser();
        $this->assertSame(array(), $annotationParser->parseTypeComment(''));
    }
}
