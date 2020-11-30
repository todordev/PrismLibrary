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
 * Collection of fields that will be fetched from database.
 *
 * @package         Prism\Library\Prism\Database
 * @subpackage      Request
 * @deprecated
 */
class Fields implements \Iterator, \Countable, \ArrayAccess
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
     * @see ArrayAccess::offsetSet()
     * @throws \InvalidArgumentException
     */
    public function offsetSet($offset, $value)
    {
        if ($value instanceof Field) {
            if (null === $offset) {
                $this->items[] = $value;
            } else {
                $this->items[$offset] = $value;
            }
        } else {
            throw new \InvalidArgumentException('Invalid value type. It should be a Field type.');
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
     * Add a field to the collection.
     *
     * @param Field $field
     *
     * @return $this
     */
    public function addField(Field $field)
    {
        $this->items[] = $field;

        return $this;
    }
}
