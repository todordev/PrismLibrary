<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Domain;

/**
 * This class contains methods used for managing collection of data.
 *
 * @package         Prism
 * @subpackage      Domain
 */
abstract class Collection implements \Iterator, \Countable, \ArrayAccess
{
    protected $items = array();

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
        return array_key_exists($this->position, $this->items) ? $this->items[$this->position] : null;
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
        return array_key_exists($offset, $this->items) ? $this->items[$offset] : null;
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
     * Return the keys of the elements.
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->items);
    }

    /**
     * Set the items of the collection.
     *
     * @param array $items
     */
    public function setItems(array $items = array())
    {
        $this->items = $items;
    }

    /**
     * Reset the data of the collection.
     */
    public function clear()
    {
        $this->items = array();
    }

    /**
     * Check for existing key.
     *
     * @param int $offset
     *
     * @return bool
     */
    public function keyExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }
}
