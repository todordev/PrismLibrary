<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration;

use Joomla\Utilities\ArrayHelper;

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
    protected static $lookup;

    /**
     * Cache of menu item IDs.
     *
     * @var array
     */
    protected static $menuItemIds = array();

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

        $option = $app->input->get('option');
        
        switch ($option) {
            case 'com_jsn':
            case 'com_easysocial':
            case 'com_socialcommunity':
                $userId = $app->input->getInt('id');
                break;

            case 'com_kunena':
            case 'com_community':
                $userId = $app->input->getInt('userid');
                break;

            default:
                $userId = 0;
                break;
        }

        if (!$userId) {
            $userId = \JFactory::getUser()->get('id');
        }

        return (int)$userId;
    }

    /**
     * Get Itemid of community builder that points to user profile.
     *
     * <code>
     * $userId = Prism\Integration\Helper::getUserId();
     * </code>
     *
     * @param string $componentName
     * @param array $needles
     *
     * @return int
     */
    public static function getItemId($componentName, $needles)
    {
        // Prepare cache hash.
        $hashString = '';
        foreach ($needles as $view => $ids) {
            // Break the loop and exit from the method,
            // if it is not array with IDs.
            if (!is_array($ids)) {
                return null;
            }

            $ids = ArrayHelper::toInteger($ids);
            $hashString .= $view . implode(',', $ids);
        }
        $hash = md5($hashString);

        // Check the cache.
        if (array_key_exists($hash, self::$menuItemIds)) {
            return self::$menuItemIds[$hash];
        }

        $app   = \JFactory::getApplication();
        $menus = $app->getMenu('site');

        // Prepare the reverse lookup array.
        // Collect all menu items and create an array that contains
        // the ID from the query string of the menu item as a key,
        // and the menu item id (Itemid) as a value
        // Example:
        // array( "category" =>
        //     1(id) => 100 (Itemid),
        //     2(id) => 101 (Itemid)
        // );
        if (self::$lookup === null) {
            self::$lookup = array();

            $component = \JComponentHelper::getComponent($componentName);
            $items     = $menus->getItems('component_id', $component->id);

            if ($items) {
                foreach ($items as $item) {
                    if (isset($item->query) and array_key_exists('view', $item->query)) {
                        $view = $item->query['view'];

                        if (!array_key_exists($view, self::$lookup)) {
                            self::$lookup[$view] = array();
                        }

                        if (array_key_exists('id', $item->query)) {
                            self::$lookup[$view][$item->query['id']] = $item->id;
                        } else { // If it is a root element that have no a request parameter ID ( categories, authors ), we set 0 for an key
                            self::$lookup[$view][0] = $item->id;
                        }
                    }
                }
            }
        }

        $result = null;
        if ($needles) {

            foreach ($needles as $view => $ids) {
                if (array_key_exists($view, self::$lookup)) {

                    foreach ($ids as $id) {
                        if (array_key_exists((int)$id, self::$lookup[$view])) {
                            $result = self::$lookup[$view][(int)$id];
                            break;
                        }
                    }

                }
            }

        } else {
            $active = $menus->getActive();
            if ($active) {
                $result = $active->id;
            }
        }

        // Set the menu item ID to the cache.
        self::$menuItemIds[$hash] = $result;

        return $result;
    }
}
