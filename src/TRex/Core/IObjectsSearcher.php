<?php
namespace TRex\Core;

interface IObjectsSearcher
{
    /**
     * Const for has and search mode.
     * Search value in a non-strict way.
     */
    const NON_STRICT_SEARCH_MODE = 'non-strict';

    /**
     * Const for has and search mode.
     * Search value in a strict way.
     */
    const STRICT_SEARCH_MODE = 'strict';

    /**
     * Const for has and search mode.
     * Search value with a regex.
     */
    const REGEX_SEARCH_MODE = 'regex';

    /**
     * Indicates if the value is present.
     *
     * @param string $value
     * @param string $searchMode
     * @return bool
     */
    public function has($value, $searchMode = self::STRICT_SEARCH_MODE);

    /**
     * Searches the keys for the value.
     *
     * @param string $value
     * @param string $searchMode
     * @return array
     */
    public function search($value, $searchMode = self::STRICT_SEARCH_MODE);
}
