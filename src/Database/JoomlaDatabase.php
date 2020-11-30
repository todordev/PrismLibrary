<?php
/**
 * @package         Prism
 * @subpackage      Database
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Database;

use Joomla\Database\DatabaseDriver;

/**
 * Base class of Joomla Database Gateway.
 *
 * @package         Prism
 * @subpackage      Database
 * @deprecated
 */
abstract class JoomlaDatabase
{
    /**
     * Database driver.
     *
     * @var DatabaseDriver
     */
    protected $db;

    /**
     * Initialize the object.
     *
     * @param DatabaseDriver $db
     */
    public function __construct(DatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Set database driver.
     *
     * @param DatabaseDriver $db
     */
    public function setDb(DatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Return database driver.
     *
     * @return DatabaseDriver
     */
    public function getDb()
    {
        return $this->db;
    }
}
