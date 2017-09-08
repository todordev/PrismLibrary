<?php
/**
 * @package         Prism\Database
 * @subpackage      Request
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database\Request;

use Prism\Database\Condition\Condition;
use Prism\Database\Condition\Conditions;
use Prism\Database\Condition\Order;
use Prism\Database\Condition\Ordering;
use Prism\Database\Condition\Limit;

/**
 * Condition used for generating a query during the process of fetching data.
 *
 * @package         Prism\Database
 * @subpackage      Request
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

    public function __construct()
    {
        $this->fields     = new Fields;
        $this->conditions = new Conditions;
        $this->ordering   = new Ordering;
        $this->limit      = new Limit;
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
