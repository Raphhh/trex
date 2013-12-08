<?php
namespace TRex\Core;

interface IObjectsModifier
{
    /**
     * Extracts the sequence of elements.
     * Starts at index $startIndex and stop after $length keys.
     *
     * @param int $startIndex
     * @param int $length
     * @param bool $areKeysPreserved
     * @return IObjects
     */
    public function extract($startIndex, $length = 0, $areKeysPreserved = true);

    /**
     * Executes the callback for every value.
     * Returns an IObjects with the result of each callback call.
     *
     * @param \Closure $callback
     * @return IObjects
     */
    public function each(\Closure $callback);

    /**
     * Executes the callback for every value.
     * Returns an IObjects with the value of witch callback has return true.
     * If no callback is passed, filters on the value itself.
     *
     * @param \Closure $callback
     * @return IObjects
     */
    public function filter(\Closure $callback = null);
}
 