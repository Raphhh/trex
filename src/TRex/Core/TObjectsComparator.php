<?php
namespace TRex\Core;

/**
 * Class TObjectsComparator
 * Implements IObjectsComparator.
 * @package TRex\Core
 */
trait TObjectsComparator
{

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function merge(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_merge', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function mergeA(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_replace', array_reverse($this->unShiftTo(func_get_args(), $this)));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function diff(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_diff', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function diffA(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_diff_assoc', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function diffK(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_diff_key', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function intersect(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_intersect', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function intersectA(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_intersect_assoc', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * {@inheritDoc}
     *
     * @param IObjects $objects
     * @return Objects
     */
    public function intersectK(IObjects $objects /*, ...*/)
    {
        return $this->apply('array_intersect_key', $this->unShiftTo(func_get_args(), $this));
    }

    /**
     * Calls a php native function with $objectsList as args.
     * Returns a new instance of Object as result.
     *
     * @param string $functionName
     * @param array $objectsList
     * @return Objects
     */
    private function apply($functionName, array $objectsList)
    {
        return new Objects(call_user_func_array($functionName, $this->parseObjectsListToArray($objectsList)));
    }

    /**
     * Transforms a list of IObjects in an simple array.
     *
     * @param array $objectsList
     * @return array
     */
    private function parseObjectsListToArray(array $objectsList)
    {
        return array_map(
            function (IObjects $objects) {
                return $objects->toArray();
            },
            $objectsList
        );
    }

    /**
     * Unshifts $value to $array.
     *
     * @param array $array
     * @param mixed $value
     * @return array
     */
    private function unShiftTo(array $array, $value)
    {
        array_unshift($array, $value);
        return $array;
    }

    /**
     * Pushes $value to $array.
     *
     * @param array $array
     * @param mixed $value
     * @return array
     */
    private function pushTo(array $array, $value)
    {
        array_push($array, $value);
        return $array;
    }
} 