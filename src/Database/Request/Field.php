<?php
/**
 * @package         Prism\Library\Database
 * @subpackage      Request
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Database\Request;

/**
 * Field that should be fetched.
 *
 * @package         Prism\Library\Database
 * @subpackage      Request
 * @deprecated
 */
class Field
{
    /**
     * Column name.
     *
     * @var string
     */
    protected $column;

    /**
     * The alias that will be as column name as result.
     *
     * @var string
     */
    protected $alias;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table;

    /**
     * Query string in raw format.
     *
     * @var string
     */
    protected $raw;

    /**
     * It shows us the column name is an alias of expression.
     *
     * @var string
     */
    protected $is_alias = false;

    public function __construct(array $data)
    {
        $this->raw      = array_key_exists('raw', $data) ? (string)$data['raw'] : '';
        $this->alias    = array_key_exists('alias', $data) ? (string)$data['alias'] : '';
        $this->column   = array_key_exists('column', $data) ? (string)$data['column'] : '';
        $this->table    = array_key_exists('table', $data) ? (string)$data['table'] : '';
        $this->is_alias = array_key_exists('is_alias', $data) ? (bool)$data['is_alias'] : false;
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
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
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
     * Check if the filed is an alias of expression.
     *
     * @return bool
     */
    public function isAlias()
    {
        return (bool)$this->is_alias;
    }
}
