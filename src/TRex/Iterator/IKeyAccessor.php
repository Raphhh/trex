<?php
namespace TRex\Iterator;

/**
 * Interface IKeyAccessor
 * @package TRex\Iterator
 */
interface IKeyAccessor
{

    /**
     * Returns all keys.
     *
     * @return array
     */
    public function getKeys();

    /**
     * Returns the key associated to the specified offset.
     * This key may be the offset or an associative key.
     * Resolves the negative offset.
     * @example TKeyAccessor::getKey(-1) give the penultimate key.
     *
     * @param int $index
     * @return mixed|null
     */
    public function getKey($index);

    /**
     * Gets the first key.
     *
     * @return mixed|null
     */
    public function getFirstKey();

    /**
     * Get the last key.
     *
     * @return mixed|null
     */
    public function getLastKey();

}
