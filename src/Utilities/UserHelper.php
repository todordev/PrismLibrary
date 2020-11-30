<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utilities;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class provides methods for interacting with user data.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
abstract class UserHelper
{
    /**
     * Return a user name.
     *
     * <code>
     * $userId = 1;
     * $numberFormatter = Prism\Library\Prism\Utilities\UserHelper::getName($userId);
     * </code>
     *
     * @param int $userId
     *
     * @throws \RuntimeException
     * @return string
     */
    public static function getName($userId)
    {
        $db    = \JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
            ->select('a.name')
            ->from($db->quoteName('#__users', 'a'))
            ->where('a.id = '. (int)$userId);

        $db->setQuery($query, 0, 1);

        return (string)$db->loadResult();
    }
}
