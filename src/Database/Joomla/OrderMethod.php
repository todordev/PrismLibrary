<?php
/**
 * @package         Prism\Database
 * @subpackage      Joomla
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database\Joomla;

use Prism\Database\Condition\Order;
use Prism\Database\Request\Request;

/**
 * Fetch methods for Joomla repository.
 *
 * @package         Prism\Database
 * @subpackage      Joomla
 */
trait OrderMethod
{
    /**
     * Prepare order conditions.
     *
     * @param \JDatabaseQuery $query
     * @param Request        $request
     */
    protected function order(\JDatabaseQuery $query, Request $request)
    {
        $orderConditions = $request->getOrdering();

        /** @var Order $condition */
        foreach ($orderConditions as $condition) {
            $orderCondition  = $condition->getTable() ? $this->db->quoteName($condition->getTable() .'.'. $condition->getColumn()) : $this->db->quoteName('a.' . $condition->getColumn());
            $orderCondition .= $condition->getDirection() ? ' '. $condition->getDirection() : '';

            $query->order($orderCondition);
        }
    }
}
