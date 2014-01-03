<?php
namespace TRex\Annotation;

use TRex\Core\Object;

/**
 * Class AnnotationParser
 * @package TRex\Annotation
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 */
class AnnotationParser extends Object
{
    /**
     * @param string $docComment
     * @return Annotations
     */
    public function getAnnotations($docComment)
    {
        $result = new Annotations();
        foreach ($this->explode($docComment) as $values) {
            if (!isset($result[$values[1]])) {
                $result[$values[1]] = new Annotation();
            }
            $result[$values[1]][] = trim($values[2]);
        }
        return $result;
    }

    /**
     * @param string $typeComment
     * @return array
     */
    public function parseTypeComment($typeComment)
    {
        if ($typeComment) {
            $words = explode(' ', $typeComment);
            return explode('|', $words[0]);
        }
        return array();
    }

    /**
     * @param string $docComment
     * @return array
     */
    private function explode($docComment)
    {
        $matches = array();
        preg_match_all('/@(.*?) (.*?)$/m', $docComment, $matches, PREG_SET_ORDER);
        return $matches;
    }
}
