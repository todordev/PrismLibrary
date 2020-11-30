<?php
/**
 * @package         Prism
 * @subpackage      Database
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Database;

use Joomla\Database\DatabaseDriver;

/**
 * Base class of Joomla Database Gateway.
 *
 * @package         Prism
 * @subpackage      Database
 */
trait Databased
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
    public function setDb(DatabaseDriver $db): void
    {
        $this->db = $db;
    }

    /**
     * Return database driver.
     *
     * @return DatabaseDriver
     */
    public function getDb(): DatabaseDriver
    {
        return $this->db;
    }
}
