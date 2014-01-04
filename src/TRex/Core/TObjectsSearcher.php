<?php
namespace TRex\Core;

/**
 * Class TObjectsSearcher.
 * Implements IObjectsSearcher.
 *
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
trait TObjectsSearcher
{
    /**
     * Needs toArray.
     *
     * @return mixed
     */
    abstract public function toArray();

    /**
     * See IObjectsComparator.
     *
     * @param string $value
     * @param string $searchMode
     * @return bool
     */
    public function has($value, $searchMode = IObjectsSearcher::STRICT_SEARCH_MODE)
    {
        if ($searchMode === IObjectsSearcher::REGEX_SEARCH_MODE) {
            return (bool)$this->search($value, $searchMode);
        }
        return in_array($value, $this->toArray(), $searchMode === IObjectsSearcher::STRICT_SEARCH_MODE);
    }

    /**
     * See IObjectsComparator.
     *
     * @param string $value
     * @param string $searchMode
     * @return array
     */
    public function search($value, $searchMode = IObjectsSearcher::STRICT_SEARCH_MODE)
    {
        if ($searchMode === IObjectsSearcher::REGEX_SEARCH_MODE) {
            return array_keys(preg_grep($value, $this->toArray()));
        }
        return array_keys($this->toArray(), $value, $searchMode === IObjectsSearcher::STRICT_SEARCH_MODE);
    }
}
