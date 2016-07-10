<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Utilities;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for interacting with data of items.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
abstract class ItemHelper
{
    /**
     * Fetch and filter the IDs of the items.
     *
     * <code>
     * $userIds = Prism\Utilities\ItemHelper::fetchIds($items, "user_id");
     * </code>
     *
     * @param array  $items
     * @param string $column
     *
     * @return array
     */
    public static function fetchIds(array $items = array(), $column = 'id')
    {
        $result = array();

        foreach ($items as $key => $item) {
            if (is_object($item) and isset($item->$column)) {
                $result[] = (int)$item->$column;
            } elseif (is_array($item) and array_key_exists($column, $item)) {
                $result[] = (int)$item[$column];
            } else {
                continue;
            }
        }

        $result = array_filter(array_unique($result));
        sort($result);

        return $result;
    }
}
