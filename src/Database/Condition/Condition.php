<?php
/**
 * @package         Prism\Database
 * @subpackage      Conditions
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database\Condition;

/**
 * Condition used for generating a query during the process of fetching data.
 *
 * @package         Prism\Database
 * @subpackage      Conditions
 */
class Condition
{
    /**
     * Condition in raw format.
     *
     * @var string
     */
    protected $raw = '';

    /**
     * The field that will be part of the condition.
     *
     * @var string
     */
    protected $column;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Table name
     *
     * @var string
     */
    protected $table;

    /**
     * Comparision operator.
     *
     * @var string
     */
    protected $operator;

    public function __construct(array $data = array())
    {
        $this->raw        = array_key_exists('raw', $data) ? (string)$data['raw'] : '';
        $this->column     = array_key_exists('column', $data) ? (string)$data['column'] : '';
        $this->value      = array_key_exists('value', $data) ? $data['value'] : '';
        $this->table      = array_key_exists('table', $data) ? (string)$data['table'] : 'a';
        $this->operator   = array_key_exists('operator', $data) ? (string)$data['operator'] : '=';
    }

    /**
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param string $raw
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param string $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTableAlias($table)
    {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }
}
