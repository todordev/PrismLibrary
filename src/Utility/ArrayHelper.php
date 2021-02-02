<?php
/**
 * @package      Prism\Library\Prism\Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

use Prism\Library\Prism\Constant\Type;

/**
 * This class provides functionality for handling arrays.
 *
 * @package Prism\Library\Prism\Utility
 */
final class ArrayHelper
{
    /**
     * Return array with IDs extracted from items.
     *
     * @param array  $items
     * @param string $column
     * @return array
     */
    public static function getIds(array $items, $column = 'id'): array
    {
        $result = array();

        foreach ($items as $item) {
            if (is_object($item) && isset($item->$column)) {
                $result[] = (int)$item->$column;
            } elseif (is_array($item) && array_key_exists($column, $item)) {
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
     * @return mixed
     */
    public static function find(array $items, mixed $value, string $column)
    {
        $result = null;

        foreach ($items as $item) {
            if (is_array($item)) {
                if (array_key_exists($column, $item) && ($value === $item[$column])) {
                    $result = $item;
                    break;
                }
            } elseif (is_object($item)) {
                if (property_exists($item, $column) && ($value === $item->$column)) {
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
     * @return array
     */
    public static function findAll(array $items, mixed $value, string $column): array
    {
        $results = array();

        foreach ($items as $item) {
            if (is_array($item)) {
                if (array_key_exists($column, $item) && ($value === $item[$column])) {
                    $results[] = $item;
                }
            } elseif (is_object($item)) {
                if (property_exists($item, $column) && ($value === $item->$column)) {
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
    public static function toOptions(array $items, array $options = array()): array
    {
        $key = array_key_exists('key', $options) ? $options['key'] : 'id';
        $text = array_key_exists('text', $options) ? $options['text'] : 'title';
        $suffix = array_key_exists('suffix', $options) ? $options['suffix'] : '';

        $results = [];

        foreach ($items as $item) {
            if (is_array($item)) {
                if ($suffix !== '' && (array_key_exists($suffix, $item) && $item[$suffix] !== '')) {
                    $results[] = array('value' => $item[$key], 'text' => $item[$text] . ' [' . $item[$suffix] . ']');
                } else {
                    $results[] = array('value' => $item[$key], 'text' => $item[$text]);
                }
            } elseif (is_object($item)) {
                if ($suffix !== '' && (isset($item->$suffix) && $item->$suffix !== '')) {
                    $results[] = array('value' => $item->$key, 'text' => $item->$text . ' [' . $item->$suffix . ']');
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
    public static function getValues(array $items, $column = 'id'): array
    {
        $keys = array();

        foreach ($items as $item) {
            if (is_array($item)) {
                $keys[] = $item[$column] ?? null;
            } elseif (is_object($item)) {
                $keys[] = $item->$column ?? null;
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
    public static function toArrayByColumn(array $items, string $column): array
    {
        $results = [];

        foreach ($items as $item) {
            if (is_array($item) && array_key_exists($column, $item)) {
                $results[$item[$column]][] = $item;
            } elseif (is_object($item) && property_exists($column, $item)) {
                $results[$item->$column][] = $item;
            }
        }

        return $results;
    }

    /**
     * Clean an array by value type.
     *
     * @param array $items
     * @param string $type
     *
     * @return array
     */
    public static function clean(array $items, string $type = Type::STRING): array
    {
        foreach ($items as $key => $item) {
            switch ($type) {
                case 'integer':
                case 'int':
                    if (!is_int($item)) {
                        unset($items[$key]);
                    }
                    break;

                case 'array':
                    if (!is_array($item)) {
                        unset($items[$key]);
                    }
                    break;

                case 'boolean':
                case 'bool':
                    if (!is_bool($item)) {
                        unset($items[$key]);
                    }
                    break;

                case 'object':
                    if (!is_object($item)) {
                        unset($items[$key]);
                    }
                    break;

                default: // string
                    if (!is_string($item)) {
                        unset($items[$key]);
                    }
                    break;
            }
        }

        return $items;
    }
}
