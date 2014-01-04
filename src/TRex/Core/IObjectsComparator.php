<?php
namespace TRex\Core;

/**
 * Interface IObjectsComparator
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IObjectsComparator
{
    /**
     * Merges a series of IObjects.
     * Does not preserve keys.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function merge(IObjects $objects);

    /**
     * Merges a series of IObjects.
     * Preserves keys.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function mergeA(IObjects $objects);

    /**
     * Compares current IObject values with the IObject params.
     * Returns all the values of current IObject that are not present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function diff(IObjects $objects);

    /**
     * Compares current IObject values and keys with the IObject params.
     * Returns all the values of current IObject that are not present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function diffA(IObjects $objects);

    /**
     * Compares current IObject keys with the IObject params.
     * Returns all the values of current IObject that are not present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function diffK(IObjects $objects);

    /**
     * Compares current IObject values with the IObject params.
     * Returns all the values of current IObject that are present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function intersect(IObjects $objects);

    /**
     * Compares current IObject values and keys with the IObject params.
     * Returns all the values of current IObject that are present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function intersectA(IObjects $objects);

    /**
     * Compares current IObject keys with the IObject params.
     * Returns all the values of current IObject that are present in the IObject params.
     *
     * @param IObjects $objects
     * @return IObjects
     */
    public function intersectK(IObjects $objects);
}
