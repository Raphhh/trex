<?php
namespace TRex\Serialization;

use TRex\Core\Enum;

/**
 * Possible hash methods for Hasher.
 *
 * @package TRex\Serialization
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class HashMethod extends Enum
{
    const SHA1 = 'sha1';
    const MD5 = 'md5';
}
