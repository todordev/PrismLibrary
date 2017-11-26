<?php
/**
 * @package         Prism\Database
 * @subpackage      Conditions
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database\Request;

/**
 * Order condition used for generating query for ordering during the process of fetching data.
 *
 * @package         Prism\Database
 * @subpackage      Conditions
 */
class Order
{
    /**
     * Order condition in raw format.
     *
     * @var string
     */
    protected $raw = '';

    /**
     * The column that will be used for ordering.
     *
     * @var string
     */
    protected $column;
    protected $value;
    protected $direction;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table;

    public function __construct(array $data = array())
    {
        $this->raw        = array_key_exists('raw', $data) ? (string)$data['raw'] : '';
        $this->direction  = array_key_exists('direction', $data) ? (string)$data['direction'] : '';
        $this->column     = array_key_exists('column', $data) ? (string)$data['column'] : '';
        $this->value      = array_key_exists('value', $data) ? (string)$data['value'] : '';
        $this->table      = array_key_exists('table', $data) ? (string)$data['table'] : 'a';
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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
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
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }
}
