<?php
namespace TRex\Iterator;

use TRex\Core\Enum;

class SortType extends Enum
{
    /**
     * Sort type by value.
     * Sort const.
     */
    const VALUE_SORT_TYPE = 'sort';

    /**
     * Sort type by key.
     * Sort const.
     */
    const KEY_SORT_TYPE = 'ksort';

    /**
     * Sort type in an associative way.
     * Sort const.
     */
    const ASSOCIATIVE_SORT_TYPE = 'asort';

    /**
     * {@inheritDoc}
     *
     * @param bool $isForCallable
     * @return mixed|string
     */
    public function getValue($isForCallable = false)
    {
        if ($isForCallable) {
            return 'u' . parent::getValue();
        }
        return parent::getValue();
    }
}
 