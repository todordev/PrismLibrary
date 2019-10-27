<?php
/**
 * @package         Prism\Library\Database
 * @subpackage      Conditions
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Database\Request;

/**
 * Collection of conditions used for filtering the data that should be fetched.
 *
 * @package         Prism\Library\Database
 * @subpackage      Conditions
 */
class Conditions implements \Iterator, \Countable, \ArrayAccess
{
    protected $items = array();
    protected $specific = array();

    protected $position = 0;

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
     * @param Order $value
     *
     * @see ArrayAccess::offsetSet()
     * @throws \InvalidArgumentException
     */
    public function offsetSet($offset, $value)
    {
        if ($value instanceof Condition) {
            if (null === $offset) {
                $this->items[] = $value;
            } else {
                $this->items[$offset] = $value;
            }
        } else {
            throw new \InvalidArgumentException('Invalid value type. It should be a Condition type.');
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
     * @param bool $resetKeys
     *
     * @return array
     */
    public function toArray($resetKeys = false)
    {
        return (!$resetKeys) ? (array)$this->items : (array)array_values($this->items);
    }

    /**
     * Add a condition to the collection.
     *
     * @param Condition $condition
     *
     * @return $this
     */
    public function addCondition(Condition $condition)
    {
        $this->items[] = $condition;

        return $this;
    }

    /**
     * @param string $key
     * @param Condition $condition
     *
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function addSpecificCondition($key, Condition $condition)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('Invalid key type.');
        }

        $this->specific[$key] = $condition;

        return $this;
    }

    /**
     * @param string $key
     *
     * @throws \InvalidArgumentException
     *
     * @return Condition|null
     */
    public function getSpecificCondition($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('Invalid key type.');
        }

        return array_key_exists($key, $this->specific) ? $this->specific[$key] : null;
    }
}
