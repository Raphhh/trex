<?php
namespace TRex\Annotation;

use TRex\Core\Objects;

/**
 * Class Annotations.
 *
 * @package TRex\Annotation
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Annotations extends Objects
{
    /**
     * {@inheritDoc}
     *
     * @param string $tag
     * @return Annotation
     */
    public function get($tag)
    {
        if ($this->exist($tag)) {
            return parent::get($tag);
        }
        return new Annotation();
    }
}
