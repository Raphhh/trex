<?php
namespace TRex\Annotation;

class AnnotationsTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $annotation = new Annotation();
        $annotations = new Annotations(array('tag1' => $annotation));
        $this->assertSame($annotation, $annotations->get('tag1'));
    }

    public function testGetEmpty()
    {
        $annotation = new Annotation();
        $annotations = new Annotations(array('tag1' => $annotation));
        $this->assertNotSame($annotation, $annotations->get('tag2'));
        $this->assertInstanceOf('TRex\Annotation\Annotation', $annotations->get('tag2'));
    }
}
