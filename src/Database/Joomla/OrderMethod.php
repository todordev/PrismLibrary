<?php
/**
 * @package         Prism\Library\Prism\Database
 * @subpackage      Joomla
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database\Joomla;

use Prism\Library\Prism\Database\Request\Order;
use Prism\Library\Prism\Database\Request\Request;

/**
 * Fetch methods for Joomla repository.
 *
 * @package         Prism\Library\Prism\Database
 * @subpackage      Joomla
 * @deprecated
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
