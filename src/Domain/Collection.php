<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Domain;

use ArrayAccess;
use Countable;
use Iterator;
use UnexpectedValueException;

/**
 * This class contains methods used for managing collection of data.
 *
 * @package         Prism
 * @subpackage      Domain
 * @deprecated  Use Laravel collection.
 */
class Collection implements Iterator, Countable, ArrayAccess
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    protected $position = 0;

    public function __construct($items = [])
    {
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
        return $this->items[$this->position] ?? null;
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
     * @return void
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
        return $this->items[$offset] ?? null;
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

    public function get($key)
    {
        return $this->items[$key] ?? null;
    }

    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }

    public function keyBy($key)
    {
        $results = new static();
        foreach ($this->items as $item) {

            if (is_string($item->$key)) {
                $resolvedKey = $item->$key;
            } elseif (is_object($item->$key)) {
                $resolvedKey = (string) $item->$key;
            } else {
                throw new UnexpectedValueException('Invalid key value.');
            }

            $results[$resolvedKey] = $item;
        }

        return new static($results);
    }
}
