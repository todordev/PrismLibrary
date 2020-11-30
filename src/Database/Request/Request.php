<?php
/**
 * @package         Prism\Library\Prism\Database
 * @subpackage      Request
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database\Request;

/**
 * Condition used for generating a query during the process of fetching data.
 *
 * @package         Prism\Library\Prism\Database
 * @subpackage      Request
 * @deprecated
 */
class Request
{
    /**
     * Collection of conditions used for filtering data.
     *
     * @var Conditions
     */
    protected $conditions;

    /**
     * Collection of conditions used for ordering.
     *
     * @var Ordering
     */
    protected $ordering;

    /**
     * The fields that should be fetched.
     *
     * @var Fields
     */
    protected $fields;

    /**
     * @var Limit
     */
    protected $limit;

    public function __construct(array $request = array())
    {
        $this->fields     = new Fields();
        if (array_key_exists('fields', $request)) {
            if (is_array($request['fields'])) {
                $this->requestFields($request['fields']);
            } elseif ($request['fields'] instanceof Fields) {
                $this->fields = $request['fields'];
            }
        }

        $this->conditions = new Conditions();
        if (array_key_exists('conditions', $request)) {
            if (is_array($request['conditions'])) {
                $this->addConditions($request['conditions']);
            } elseif ($request['conditions'] instanceof Conditions) {
                $this->conditions = $request['conditions'];
            }
        }

        $this->ordering   = new Ordering();
        if (array_key_exists('ordering', $request) && ($request['ordering'] instanceof Ordering)) {
            $this->ordering = $request['conditions'];
        }

        $this->limit      = new Limit();
        if (array_key_exists('limit', $request) && ($request['limit'] instanceof Limit)) {
            $this->limit = $request['limit'];
        }
    }

    /**
     * @param Fields $fields
     *
     * @return $this
     */
    public function setFields(Fields $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return Fields
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param Conditions|null $conditions
     *
     * @return $this
     */
    public function setConditions(Conditions $conditions = null)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * @return Conditions
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param Ordering $ordering
     *
     * @return $this
     */
    public function setOrder(Ordering $ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * @return Ordering
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param Limit $limit
     *
     * @return $this
     */
    public function setLimit(Limit $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return Limit
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param Condition $condition
     *
     * @return self
     */
    public function addCondition(Condition $condition)
    {
        $this->conditions->addCondition($condition);

        return $this;
    }

    /**
     * @param string $key
     * @param Condition $condition
     *
     * @return self
     * @throws \InvalidArgumentException
     */
    public function addSpecificCondition($key, Condition $condition)
    {
        $this->conditions->addSpecificCondition($key, $condition);

        return $this;
    }

    /**
     * Simple way to add conditions.
     *
     * @param array $conditions
     *
     * @return self
     */
    public function addConditions(array $conditions)
    {
        foreach ($conditions as $columnName => $value) {
            if ($value instanceof Condition) {
                $this->conditions->addCondition($value);
            } elseif (is_string($columnName)) {
                $this->conditions->addCondition(new Condition(['column' => $columnName, 'value' => $value]));
            }
        }

        return $this;
    }

    /**
     * @param Field $field
     *
     * @return self
     */
    public function requestField(Field $field)
    {
        $this->fields->addField($field);

        return $this;
    }

    /**
     * Simple way to request fields.
     *
     * @param array $fields
     *
     * @return self
     */
    public function requestFields(array $fields)
    {
        foreach ($fields as $columnName) {
            if (is_string($columnName)) {
                $this->fields->addField(new Field(['column' => $columnName]));
            }
        }

        return $this;
    }
    /**
     * @param Order $condition
     *
     * @return self
     */
    public function addOrderCondition(Order $condition)
    {
        $this->ordering->addCondition($condition);

        return $this;
    }
}
