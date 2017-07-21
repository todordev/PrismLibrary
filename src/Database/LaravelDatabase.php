<?php
/**
 * @package         Prism
 * @subpackage      Database
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database;

use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Base class of Larave Database Gateway.
 *
 * @package         Prism
 * @subpackage      Database
 */
abstract class LaravelDatabase
{
    /**
     * Database driver.
     *
     * @var QueryBuilder
     */
    protected $db;

    /**
     * Initialize the object.
     *
     * @param QueryBuilder $db
     */
    public function __construct(QueryBuilder $db = null)
    {
        $this->db = $db;
    }

    /**
     * Set database driver.
     *
     * @param QueryBuilder $db
     */
    public function setDb(QueryBuilder $db)
    {
        $this->db = $db;
    }

    /**
     * Return database driver.
     *
     * @return QueryBuilder
     */
    public function getDb()
    {
        return $this->db;
    }
}
