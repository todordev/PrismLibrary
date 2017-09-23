<?php
/**
 * @package         Prism
 * @subpackage      Database
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database;

use \Prism\Database\Request\Condition;
use \Prism\Database\Request\Limit;
use \Prism\Database\Request\Order;
use \Prism\Database\Request\Field;
use \Prism\Database\Request\Request;

/**
 * Base class of Joomla Database Gateway.
 *
 * @package         Prism
 * @subpackage      Database
 */
abstract class JoomlaDatabaseGateway
{
    /**
     * Database driver.
     *
     * @var \JDatabaseDriver
     */
    protected $db;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Set database driver.
     *
     * @param \JDatabaseDriver $db
     */
    public function setDb(\JDatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Return database driver.
     *
     * @return \JDatabaseDriver
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Prepare some query filters.
     *
     * @param \JDatabaseQuery $query
     * @param Request         $request
     *
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    protected function filter(\JDatabaseQuery $query, Request $request)
    {
        $conditions = $request->getConditions();

        // Filter by other conditions.
        /** @var Condition $condition */
        foreach ($conditions as $condition) {
            if (!$condition->getOperator()) {
                throw new \UnexpectedValueException('Please, set comparision operator for column: '.$condition->getColumn());
            }

            $columnName = $condition->getTable() ? $condition->getTable() .'.'. $condition->getColumn() : 'a.' . $condition->getColumn();
            $query->where($this->db->quoteName($columnName) . $condition->getOperator() . $this->db->quote($condition->getValue()));
        }
    }

    /**
     * Prepare order conditions.
     *
     * @param \JDatabaseQuery $query
     * @param Request         $request
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

    /**
     * Prepare limitation results number and set the query to the database driver.
     *
     * @param \JDatabaseQuery $query
     * @param Request         $request
     */
    protected function limit(\JDatabaseQuery $query, Request $request)
    {
        /** @var Limit $limit */
        $limit = $request->getLimit();
        if ($limit->getOffset() || $limit->getLimit()) {
            $this->db->setQuery($query, $limit->getOffset(), $limit->getLimit());
        } else {
            $this->db->setQuery($query);
        }
    }

    /**
     * Prepare list of columns that should be fetched.
     *
     * @param Request $request
     * @param array $defaultFields
     * @param array $aliasFields
     *
     * @return array
     */
    protected function prepareFields($request, array $defaultFields, array $aliasFields = array())
    {
        $fields = array();

        if ($request !== null) {
            $requiredFields = $request->getFields();

            // Generate fields list.
            if (count($requiredFields) > 0) {
                /** @var Field $field */
                foreach ($requiredFields as $field) {
                    if ($field->isAlias() && array_key_exists($field->getColumn(), $aliasFields)) {
                        $fields[] = $aliasFields[$field->getColumn()];
                    } else {
                        $requireField = $field->getTable() ? $field->getTable() . '.' . $field->getColumn() : 'a.' . $field->getColumn();
                        if (!in_array($requireField, $defaultFields, true)) {
                            continue;
                        }

                        if ($field->getAlias()) {
                            $requireField .= ' AS ' . $field->getAlias();
                        }

                        $fields[] = $requireField;
                    }
                }
            }
        }

        return count($fields) > 0 ? $fields : $defaultFields;
    }

    abstract protected function getQuery(Request $request = null);
}
