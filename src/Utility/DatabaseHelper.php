<?php
/**
 * @package      Prism
 * @subpackage   Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

use Joomla\Database\DatabaseDriver;

/**
 * This class provides methods used for interaction with database servers.
 *
 * @package Prism\Library\Prism\Utility
 */
final class DatabaseHelper
{
    /**
     * Check if it is MariaDB server.
     *
     * @param   DatabaseDriver $db
     * @return  bool
     */
    public static function isMariaDB(DatabaseDriver $db)
    {
        $query = 'SHOW VARIABLES LIKE ' . $db->quote('version');

        $db->setQuery($query);

        $result = (array)$db->loadRow();

        $isMariaDb = false;
        if (array_key_exists(1, $result)) {
            $isMariaDb = str_contains($result[1], 'MariaDB');
        }

        return $isMariaDb;
    }

    /**
     * Add table prefix to table name.
     *
     * @param string $tableName
     * @param string $prefix
     * @return string
     */
    public static function prefix(string $tableName, string $prefix): string
    {
        return str_replace('#__', $prefix, $tableName);
    }
}
