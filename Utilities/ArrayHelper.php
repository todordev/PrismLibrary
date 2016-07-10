<?php
/**
 * @package      Prism\Utilities
 * @subpackage   Array
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Utilities;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for handling arrays.
 *
 * @package      Prism\Utilities
 * @subpackage   Array
 */
abstract class ArrayHelper
{
    /**
     * Return array with IDs extracted from items.
     *
     * <code>
     * $userIds = Prism\Utilities\ArrayHelper::getIds($items);
     * </code>
     *
     * @param array $items
     * @param string $column
     *
     * @return array
     */
    public static function getIds(array $items, $column = 'id')
    {
        $result = array();

        foreach ($items as $item) {
            if (is_object($item) and isset($item->$column)) {
                $result[] = (int)$item->$column;
            } elseif (is_array($item) and array_key_exists($column, $item)) {
                $result[] = (int)$item[$column];
            }
        }

        $result = array_filter(array_unique($result));
        sort($result, SORT_NUMERIC);

        return $result;
    }
}
