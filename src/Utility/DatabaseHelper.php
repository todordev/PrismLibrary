<?php
/**
 * @package      Prism
 * @subpackage   Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

/**
 * This class provides methods used for interaction with database servers.
 *
 * @package     Prism
 * @subpackage  Utility
 */
abstract class DatabaseHelper
{
    /**
     * Check if it is MariaDB server.
     *
     * @param   \JDatabaseDriver $db
     *
     * @return  bool
     *
     * @throws \RuntimeException
     */
    public static function isMariaDB(\JDatabaseDriver $db)
    {
        $query = 'SHOW VARIABLES LIKE '. $db->quote('version');

        $db->setQuery($query);

        $result = (array)$db->loadRow();

        $isMariaDb = false;
        if (array_key_exists(1, $result)) {
            $isMariaDb = (false !== strpos($result[1], 'MariaDB'));
        }

        return $isMariaDb;
    }

    /**
     * Add table prefix to table name.
     *
     * @param string $tableName
     * @param string $prefix
     *
     * @return string
     */
    public static function prefix($tableName, $prefix)
    {
        return (string)str_replace('#__', $prefix, $tableName);
    }
}
