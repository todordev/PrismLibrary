<?php
/**
 * @package         Prism
 * @subpackage      Database\Arrays
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for handling objects as array.
 * The data has to be loaded from database.
 *
 * @package         Prism
 * @subpackage      Database\Arrays
 */
abstract class ArrayObject implements \Iterator, \Countable, \ArrayAccess
{
    protected $items = array();

    /**
     * Database driver.
     * 
     * @var \JDatabaseDriver
     */
    protected $db;

    protected $position = 0;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db = null)
    {
        $this->db   = $db;
    }

    abstract public function load($options = array());

    /**
     * Set a database object.
     *
     * <code>
     * $object    = new Prism\Database\ArrayObject;
     *
     * $object->setDb(\JFactory::getDbo());
     * </code>
     *
     * @param \JDatabaseDriver $db
     *
     * @return self
     */
    public function setDb(\JDatabaseDriver $db)
    {
        $this->db = $db;

        return $this;
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Return the current element.
     *
     * @return mixed
     *
     * @see Iterator::current()
     */
    public function current()
    {
        return (!array_key_exists($this->position, $this->items)) ? null : $this->items[$this->position];
    }

    /**
     * Return the key of the current element.
     *
     * @return int
     *
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Move forward to next element.
     *
     * @see Iterator::next()
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Checks if current position is valid.
     *
     * @return bool
     *
     * @see Iterator::valid()
     */
    public function valid()
    {
        return array_key_exists($this->position, $this->items);
    }

    /**
     * Count elements of an object.
     *
     * @return int
     *
     * @see Countable::count()
     */
    public function count()
    {
        return (int)count($this->items);
    }

    /**
     * Offset to set.
     *
     * @param int $offset
     * @param mixed $value
     *
     * @return mixed
     *
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Whether a offset exists.
     *
     * @param int $offset
     *
     * @return mixed
     *
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Offset to unset.
     *
     * @param int $offset
     *
     * @return mixed
     *
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * Offset to retrieve.
     *
     * @param int $offset
     *
     * @return mixed
     *
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        return (!array_key_exists($offset, $this->items)) ? null : $this->items[$offset];
    }

    /**
     * Return items as array.
     *
     * @return array
     */
    public function toArray()
    {
        return (array)$this->items;
    }

    /**
     * Return the element keys.
     *
     * <code>
     * $groups = new Gamification\Group\Groups(JFactory::getDbo());
     * $groups->load();
     *
     * $keys = $groups->getKeys("id");
     * </code>
     *
     * @param string $columnName
     *
     * @return array
     */
    public function getKeys($columnName = 'id')
    {
        $keys = array();

        foreach ($this->items as $item) {
            if (is_array($item)) {
                $keys[] = array_key_exists($columnName, $item) ? $item[$columnName] : null;
            } elseif (is_object($item)) {
                $keys[] = isset($item->$columnName) ? $item->$columnName : null;
            }
        }

        return $keys;
    }

    /**
     * Prepare an array as options that could be used in select form elements.
     *
     * <code>
     * $groups = new Gamification\Group\Groups(JFactory::getDbo());
     * $groups->load();
     *
     * $options = $groups->toOptions("id", "name");
     * </code>
     *
     * @param string $key The name of the property used for value.
     * @param string $text The name of the property used for text.
     * @param string $suffix The name of the property that can be included to the text.
     *
     * @return array
     */
    public function toOptions($key = 'id', $text = 'title', $suffix = '')
    {
        $options = array();

        foreach ($this->items as $item) {
            if (!$suffix) {
                $options[] = array('value' => $item[$key], 'text' => $item[$text]);
            } else {
                $options[] = array('value' => $item[$key], 'text' => $item[$text] . ' ['.$item[$suffix].']');
            }
        }

        return $options;
    }

    /**
     * Search in the results of arrays.
     *
     * <code>
     * $groups = new Gamification\Group\Groups(JFactory::getDbo());
     * $groups->load();
     *
     * $options = $groups->find(1, "id");
     * </code>
     *
     * @param mixed $value The value that we will search.
     * @param string $column The column where we will search.
     *
     * @return array
     */
    public function find($value, $column)
    {
        $result = array();

        foreach ($this->items as $item) {
            if (array_key_exists($column, $item) and ($value == $item[$column])) {
                $result = $item;
                break;
            }
        }

        return $result;
    }
}
