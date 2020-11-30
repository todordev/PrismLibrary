<?php
/**
 * @package         Prism\Library\Prism\Database
 * @subpackage      Conditions
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database\Request;

/**
 * Limit of the result when we fetch data.
 *
 * @package         Prism\Library\Prism\Database
 * @subpackage      Conditions
 * @deprecated
 */
class Limit
{
    /**
     * Starting point of the query results.
     *
     * @var int
     */
    protected $offset;

    /**
     * Number of result that should be returned.
     *
     * @var int
     */
    protected $limit;

    /**
     * Initialize the object.
     *
     * @param int $offset
     * @param int $limit
     */
    public function __construct($offset = 0, $limit = 0)
    {
        $this->offset = (int)abs($offset);
        $this->limit  = (int)abs($limit);
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return (int)$this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = (int)abs($offset);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return (int)$this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;
    }
}
