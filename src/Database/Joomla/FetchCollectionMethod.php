<?php
/**
 * @package         Prism\Library\Database
 * @subpackage      Joomla
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Database\Joomla;

use Prism\Library\Database\Request\Request;

/**
 * Fetch method for collections used in Joomla database gateways.
 *
 * @package         Prism\Library\Database
 * @subpackage      Joomla
 * @deprecated
 */
trait FetchCollectionMethod
{
    /**
     * Load the data from database and return a collection.
     *
     * <code>
     * // Prepare specific conditions.
     * $usersIds    = new Prism\Library\Database\Request\Condition(['column' => 'user_id', 'value' => [1,2,3,4], 'operator' => 'IN']);
     *
     * $conditions  = new Prism\Library\Database\Request\Conditions;
     * $conditions->addSpecificCondition($usersIds);
     *
     * // Prepare database request.
     * $databaseRequest = new Prism\Library\Database\Request\Request;
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
