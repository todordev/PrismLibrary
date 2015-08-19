<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods which creates social profile object,
 * based on social extension name.
 *
 * @package      Prism
 * @subpackage   Integrations\Helpers
 */
abstract class Helper
{
    /**
     * Get a user ID from request.
     * This method should be used for pages,
     * which are intended to be use profiles and provides details about user.
     * Those pages should contains user ID with request parameters.
     *
     * <code>
     * $userId = Prism\Integration\Helper::getUserId();
     * </code>
     *
     * @return int
     */
    public static function getUserId()
    {
        $app = \JFactory::getApplication();
        /** @var $app \JApplicationSite */

        $option = $app->input->get("option");
        
        switch ($option) {

            case "com_jsn":
            case "com_easysocial":
            case "com_socialcommunity":
                $userId = $app->input->getInt("id");
                break;

            case "com_kunena":
            case "com_community":
                $userId = $app->input->getInt("userid");
                break;

            default:
                $userId = 0;
                break;
        }

        if (!$userId) {
            $userId = \JFactory::getUser()->get("id");
        }

        return (int)$userId;
    }
}
