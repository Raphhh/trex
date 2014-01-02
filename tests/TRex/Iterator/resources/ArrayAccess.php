<?php
namespace TRex\Iterator\resources;

use TRex\Iterator\TArrayAccess;

/**
 * Class ArrayAccess
 * Mock for TArrayAccess.
 * @package TRex\Iterator\resources
 */
class ArrayAccess
{
    use TArrayAccess;

    public function getIterator()
    {
    }
}
