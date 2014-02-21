<?php
namespace TRex\Annotation;

use TRex\Core\Object;

/**
 * AnnotationParser parse doc comment to Annotation.
 *
 * @package TRex\Annotation
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 */
class AnnotationParser extends Object
{
    /**
     * Parse doc comment to Annotations.
     *
     * @param string $docComment
     * @return Annotations
     */
    public function getAnnotations($docComment)
    {
        $result = new Annotations();
        foreach ($this->explodeDocComment($docComment) as $values) {
            if (!isset($result[$values[1]])) {
                $result[$values[1]] = new Annotation();
            }
            $result[$values[1]][] = trim($values[2]);
        }
        return $result;
    }

    /**
     * Parse a type doc comment.
     *
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
     * Explodes a string by tag.
     *
     * @param string $docComment
     * @return array
     */
    private function explodeDocComment($docComment)
    {
        $matches = array();
        preg_match_all('/@(.*?)[[:blank:]](.*?)$/m', $docComment, $matches, PREG_SET_ORDER);
        return $matches;
    }
}
