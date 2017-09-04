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
 * Fetch methods used in Joomla database gateways.
 *
 * @package         Prism\Database
 * @subpackage      Joomla
 */
trait FetchMethods
{
    /**
     * Fetch a data from database by item ID.
     *
     * <code>
     * // Prepare fields that should be fetched.
     * $fieldId       = new \Prism\Database\Request\Field(['column' => 'id', 'table' => 'a']);
     * $fieldContent  = new \Prism\Database\Request\Field(['column' => 'content', 'table' => 'a']);
     *
     * $fields  = new \Prism\Database\Request\Fields;
     * $fields
     *    ->addField($fieldId)
     *    ->addField($fieldContent);
     *
     * // Prepare database request.
     * $databaseRequest = new \Prism\Database\Request\Request;
     * $databaseRequest->setFields($fields);
     *
     * $itemId = 1;
     *
     * $gateway = new JoomlaGateway(\JFactory::getDbo());
     * $items   = $gateway->fetchById($itemId, $databaseRequest);
     * </code>
     *
     * @param int $id
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     *
     * @return array
     */
    public function fetchById($id, Request $request = null)
    {
        if (!$id) {
            throw new \InvalidArgumentException('There is no ID.');
        }

        $query = $this->getQuery($request);

        // Filter by ID.
        $query->where('a.id = ' . (int)$id);

        $this->db->setQuery($query);

        return (array)$this->db->loadAssoc();
    }

    /**
     * Load the data from database by conditions and return an entity.
     *
     * <code>
     * // Prepare conditions.
     * $userId      = new \Prism\Database\Condition\Condition(['column' => 'user_id', 'value' => $userId, 'operator' => '=']);
     * $createAt    = new \Prism\Database\Condition\Condition(['column' => 'created_at', 'value' => '2012-10-12', 'operator' => '=']);
     *
     * $conditions  = new \Prism\Database\Condition\Conditions;
     * $conditions
     *  ->addCondition($userId)
     *  ->addCondition($createAt);
     *
     * // Prepare database request.
     * $databaseRequest = new \Prism\Database\Request\Request;
     * $databaseRequest->setConditions($conditions);
     *
     * $gateway = new JoomlaGateway(\JFactory::getDbo());
     * $item    = $gateway->fetch($databaseRequest);
     * </code>
     *
     * @param Request $request
     *
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     *
     * @return array
     */
    public function fetch(Request $request)
    {
        /** @var Request $request */
        if (!$request) {
            throw new \UnexpectedValueException('There are no request that the system should use to fetch data.');
        }

        $query = $this->getQuery($request);
        $this->filter($query, $request);

        $this->db->setQuery($query);

        return (array)$this->db->loadAssoc();
    }
}
