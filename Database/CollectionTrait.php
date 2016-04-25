<?php
/**
 * @package         Prism
 * @subpackage      Database\Objects
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database;

use Joomla\Utilities\ArrayHelper;

defined('JPATH_PLATFORM') or die;

/**
 * This trait provides methods for objects used as collection.
 *
 * @package         Prism
 * @subpackage      Database\Collections
 */
trait CollectionTrait
{
    /**
     * Prepare order column that will be used in where clause of a query.
     *
     * @param array $options
     * @param string $default
     *
     * @return string
     */
    protected function getOptionOrderColumn(array $options, $default = null)
    {
        return (!array_key_exists('order_column', $options)) ? $default : $options['order_column'];
    }

    /**
     * Prepare order direction that will be used in where clause of a query.
     *
     * @param array $options
     * @param string $default
     *
     * @return string
     */
    protected function getOptionOrderDirection(array $options, $default = 'DESC')
    {
        $orderDirection = (!array_key_exists('order_direction', $options)) ? $default : $options['order_direction'];
        return (strcmp('DESC', $orderDirection) === 0) ? 'DESC' : 'ASC';
    }

    /**
     * Prepare starting point for loading data that will be used in a query.
     *
     * @param array $options
     * @param int $default
     *
     * @return string
     */
    protected function getOptionStart(array $options, $default = 0)
    {
        return (!array_key_exists('start', $options)) ? $default : (int)$options['start'];
    }

    /**
     * Prepare result limit that will be used in a query.
     *
     * @param array $options
     * @param int $default
     *
     * @return string
     */
    protected function getOptionLimit(array $options, $default = 10)
    {
        return (!array_key_exists('limit', $options)) ? $default : (int)$options['limit'];
    }

    /**
     * Prepare a state that will be used in a query as filter.
     *
     * @param array $options
     * @param int|null $default
     *
     * @return string
     */
    protected function getOptionState(array $options, $default = null)
    {
        return (!array_key_exists('state', $options)) ? $default : (int)$options['state'];
    }

    /**
     * Prepare access groups that will be used in a query as filter.
     *
     * @param array $options
     *
     * @return array|null
     */
    protected function getOptionAccessGroups(array $options)
    {
        return (!array_key_exists('access_groups', $options)) ? null : (array)$options['access_groups'];
    }

    /**
     * Prepare an ID that will be used in a query as filter.
     *
     * @param array $options
     * @param string $index
     *
     * @return string
     */
    protected function getOptionId(array $options, $index = 'id')
    {
        return (!array_key_exists($index, $options)) ? 0 : (int)$options[$index];
    }

    /**
     * Prepare IDs that will be used in a query as filter.
     *
     * @param array $options
     * @param string $index
     *
     * @return string
     */
    protected function getOptionIds(array $options, $index = 'ids')
    {
        $ids = (array_key_exists($index, $options) and is_array($options[$index])) ? $options[$index] : array();
        $ids = array_filter(array_unique($ids));
        $ids = ArrayHelper::toInteger($ids);

        return $ids;
    }
}
