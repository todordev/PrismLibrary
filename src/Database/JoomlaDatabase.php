<?php
/**
 * @package         Prism
 * @subpackage      Database
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Database;

/**
 * Base class of Joomla Database Gateway.
 *
 * @package         Prism
 * @subpackage      Database
 */
abstract class JoomlaDatabase
{
    /**
     * Database driver.
     *
     * @var \JDatabaseDriver
     */
    protected $db;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Set database driver.
     *
     * @param \JDatabaseDriver $db
     */
    public function setDb(\JDatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Return database driver.
     *
     * @return \JDatabaseDriver
     */
    public function getDb()
    {
        return $this->db;
    }
}
