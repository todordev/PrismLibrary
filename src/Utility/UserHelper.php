<?php
/**
 * @package      Prism\Library\Prism\Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

use Joomla\Database\DatabaseDriver;

/**
 * This class provides methods for interacting with user data.
 *
 * @package Prism\Library\Prism\Utility
 */
final class UserHelper
{
    private DatabaseDriver $db;

    public function __construct(DatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Return a user name.
     *
     * @param int $userId
     *
     * @throws \RuntimeException
     * @return string
     */
    public function getName(int $userId): string
    {
        $query = $this->db->getQuery(true);

        $query
            ->select('a.name')
            ->from($this->db->quoteName('#__users', 'a'))
            ->where('a.id = ' . $userId);

        $this->db->setQuery($query, 0, 1);

        return (string)$this->db->loadResult();
    }
}
