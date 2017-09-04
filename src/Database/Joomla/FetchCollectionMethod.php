<?php
/**
 * @package         Prism\Database
 * @subpackage      Joomla
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database\Joomla;

use Prism\Database\Request\Request;

/**
 * Fetch method for collections used in Joomla database gateways.
 *
 * @package         Prism\Database
 * @subpackage      Joomla
 */
trait FetchCollectionMethod
{
    /**
     * Load the data from database and return a collection.
     *
     * <code>
     * // Prepare specific conditions.
     * $usersIds    = new \Prism\Database\Condition\Condition(['column' => 'user_id', 'value' => [1,2,3,4], 'operator' => 'IN']);
     *
     * $conditions  = new \Prism\Database\Condition\Conditions;
     * $conditions->addSpecificCondition($usersIds);
     *
     * // Prepare database request.
     * $databaseRequest = new \Prism\Database\Request\Request;
     * $databaseRequest->setConditions($conditions);
     *
     * $gateway = new JoomlaGateway(\JFactory::getDbo());
     * $items   = $gateway->fetchCollection($request);
     * </code>
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \RuntimeException
     *
     * @return array
     */
    public function fetchCollection(Request $request)
    {
        /** @var Request $request */
        if (!$request) {
            throw new \UnexpectedValueException('There are no request that the system should use to fetch data.');
        }

        $query = $this->getQuery($request);
        $this->filter($query, $request);
        $this->order($query, $request);
        $this->limit($query, $request);

        return (array)$this->db->loadAssocList();
    }
}
