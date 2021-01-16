<?php
/**
 * @package         Prism
 * @subpackage      Database
 * @author       FunFex <opensource@funfex.com>
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database;

use Joomla\Database\DatabaseDriver;

/**
 * Trait for classes that need database driver.
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
    protected DatabaseDriver $db;

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
