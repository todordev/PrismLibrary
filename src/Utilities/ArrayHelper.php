<?php
/**
 * @package      Prism\Utilities
 * @subpackage   Array
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
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
     * @param array  $items
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

    /**
     * Search for an item.
     *
     * @param array $items
     * @param mixed $value The value that we will search.
     * @param string $column The column where we will search.
     *
     * @return mixed
     */
    public static function find(array $items, $value, $column)
    {
        $result = null;

        foreach ($items as $item) {
            if (is_array($item)) {
                if (array_key_exists($column, $item) and ($value == $item[$column])) {
                    $result = $item;
                    break;
                }
            } elseif (is_object($item)) {
                if (property_exists($item, $column) and ($value == $item->$column)) {
                    $result = $item;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Search items and return all elements that match to column and value.
     *
     * @param array $items
     * @param mixed $value The value that we will search.
     * @param string $column The column where we will search.
     *
     * @return array
     */
    public static function findAll(array $items, $value, $column)
    {
        $results = array();

        foreach ($items as $item) {
            if (is_array($item)) {
                if (array_key_exists($column, $item) and ($value == $item[$column])) {
                    $results[] = $item;
                }
            } elseif (is_object($item)) {
                if (property_exists($item, $column) and ($value == $item->$column)) {
                    $results[] = $item;
                }
            }
        }

        return $results;
    }

    /**
     * Prepare an array as options that could be used in select form elements.
     *
     * <code>
     * $options = array(
     *    'key' => 'id',
     *    'text' => 'title',
     *    'suffix' => ''
     * );
     *
     * $selectOptions = ArrayHelper::toOptions($items, $options);
     * </code>
     *
     * @param array $items
     * @param array $options An array that shows which columns will be used for 'key', 'text' and 'suffix'.
     *
     * @return array
     */
    public static function toOptions(array $items, array $options = array())
    {
        $key = array_key_exists('key', $options) ? $options['key'] : 'id';
        $text = array_key_exists('text', $options) ? $options['text'] : 'title';
        $suffix = array_key_exists('suffix', $options) ? $options['suffix'] : '';

        $results = array();

        foreach ($items as $item) {
            if (is_array($item)) {
                if ($suffix !== '' and (array_key_exists($suffix, $item) and $item[$suffix] !== '')) {
                    $results[] = array('value' => $item[$key], 'text' => $item[$text] . ' ['.$item[$suffix].']');
                } else {
                    $results[] = array('value' => $item[$key], 'text' => $item[$text]);
                }
            } elseif (is_object($item)) {
                if ($suffix !== '' and (isset($item->$suffix) and $item->$suffix !== '')) {
                    $results[] = array('value' => $item->$key, 'text' => $item->$text . ' ['.$item->$suffix.']');
                } else {
                    $results[] = array('value' => $item->$key, 'text' => $item->$text);
                }
            }
        }

        return $results;
    }

    /**
     * Return property values of the elements.
     *
     * @param array $items
     * @param string $column
     *
     * @return array
     */
    public function getValues(array $items, $column = 'id')
    {
        $keys = array();

        foreach ($items as $item) {
            if (is_array($item)) {
                $keys[] = array_key_exists($column, $item) ? $item[$column] : null;
            } elseif (is_object($item)) {
                $keys[] = isset($item->$column) ? $item->$column : null;
            }
        }

        return $keys;
    }

    /**
     * Return items as array indexed by column value.
     *
     * @param array $items
     * @param string $column
     *
     * @return array
     */
    public function toArrayByColumn(array $items, $column)
    {
        $results = array();

        foreach ($items as $item) {
            if (is_array($item) and array_key_exists($column, $item)) {
                $results[$item[$column]][] = $item;
            } elseif (is_object($item) and property_exists($column, $item)) {
                $results[$item->$column][] = $item;
            }
        }

        return $results;
    }
}
