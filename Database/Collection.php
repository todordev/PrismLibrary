<?php
/**
 * @package         Prism
 * @subpackage      Database\Collections
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database;

use Joomla\Utilities\ArrayHelper;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods used for managing collection of data.
 * The data will be loaded from database.
 *
 * @package         Prism
 * @subpackage      Database\Collections
 */
abstract class Collection implements \Iterator, \Countable, \ArrayAccess
{
    protected $items = array();

    /**
     * Gives information about the type of the items array.
     *
     * @var bool
     */
    protected $isMultidimensional = false;

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
        $this->db = $db;
    }

    abstract public function load(array $options = array());

    /**
     * Set a database object.
     *
     * <code>
     * $object    = new Prism\Database\Collection;
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
     * Count elements of an object by additional criteria.
     *
     * @param array $options
     *
     * @return array
     */
    public function advancedCount(array $options = array())
    {
        $key = (!array_key_exists('key', $options)) ? null : $options['key'];

        $results = array();

        if ($this->isMultidimensional) {
            foreach ($this->items as $key1 => $items) {
                foreach ($items as $item) {
                    if (array_key_exists($key, $item)) {
                        if (!array_key_exists($key, $results[$key1])) {
                            $results[$key1][$key] = 0;
                        } else {
                            $results[$key1][$key]++;
                        }
                    }
                }
            }
        } else {
            foreach ($$this->items as $item) {
                if (array_key_exists($key, $item)) {
                    if (!array_key_exists($key, $results)) {
                        $results[$key] = 0;
                    } else {
                        $results[$key]++;
                    }
                }
            }
        }

        return $results;
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
     * @param bool $resetKeys
     *
     * @return array
     */
    public function toArray($resetKeys = false)
    {
        return (!$resetKeys) ? (array)$this->items : (array)array_values($this->items);
    }

    /**
     * Convert all items to stdObject.
     *
     * @return array
     */
    public function toObjects()
    {
        $items_ = array();
        foreach ($this->items as $item) {
            $items_[] = (object)$item;
        }

        return $items_;
    }

    /**
     * Return the keys of the elements.
     *
     * <code>
     * $groups = new Gamification\Group\Groups(JFactory::getDbo());
     * $groups->load();
     *
     * $keys = $groups->getKeys();
     * </code>
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
     * <code>
     * $items = array(
     *    array('name' => 'John Doe'),
     *    array('name' => 'Jane Doe'),
     * );
     *
     * $groups = new Gamification\Group\Groups(JFactory::getDbo());
     * $groups->setItems($items);
     * </code>
     *
     * @param array $items
     */
    public function setItems(array $items = array())
    {
        $this->items = $items;
    }

    /**
     * Return property values of the elements.
     *
     * <code>
     * $groups = new Gamification\Group\Groups(JFactory::getDbo());
     * $groups->load();
     *
     * $values = $groups->getValues("title");
     * </code>
     *
     * @param string $columnName
     *
     * @return array
     */
    public function getValues($columnName = 'id')
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
            if (is_array($item)) {
                if ($suffix !== '' and (array_key_exists($suffix, $item) and $item[$suffix] !== '')) {
                    $options[] = array('value' => $item[$key], 'text' => $item[$text] . ' ['.$item[$suffix].']');
                } else {
                    $options[] = array('value' => $item[$key], 'text' => $item[$text]);
                }
            } elseif (is_object($item)) {
                if ($suffix !== '' and (isset($item->$suffix) and $item->$suffix !== '')) {
                    $options[] = array('value' => $item->$key, 'text' => $item->$text . ' ['.$item->$suffix.']');
                } else {
                    $options[] = array('value' => $item->$key, 'text' => $item->$text);
                }
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

    /**
     * Mark the array that contains the items as multidimensional.
     */
    public function flagMultidimensional()
    {
        $this->isMultidimensional = true;
    }

    /**
     * Prepare order column that will be used in where clause of a query.
     *
     * @param array $options
     * @param string $default
     *
     * @return string
     */
    protected function getOptionOrderColumn(array $options, $default = '')
    {
        if (!is_string($default)) {
            $default = '';
        }

        return (!array_key_exists('order_column', $options)) ? $default : (string)$options['order_column'];
    }

    /**
     * Prepare order direction that will be used in where clause of a query.
     *
     * @param array $options
     * @param string $default
     *
     * @return string
     */
    protected function getOptionOrderDirection(array $options, $default = 'DESC')
    {
        $orderDirection = (!array_key_exists('order_direction', $options)) ? $default : $options['order_direction'];
        return (strcmp('DESC', $orderDirection) === 0) ? 'DESC' : 'ASC';
    }

    /**
     * Prepare starting point for loading data that will be used in a query.
     *
     * @param array $options
     * @param int $default
     *
     * @return int
     */
    protected function getOptionStart(array $options, $default = 0)
    {
        return (!array_key_exists('start', $options)) ? (int)$default : (int)$options['start'];
    }

    /**
     * Prepare result limit that will be used in a query.
     *
     * @param array $options
     * @param int $default
     *
     * @return int
     */
    protected function getOptionLimit(array $options, $default = 10)
    {
        return (!array_key_exists('limit', $options)) ? (int)$default : (int)$options['limit'];
    }

    /**
     * Prepare a state that will be used in a query as filter.
     *
     * @param array $options
     * @param int|null $default
     *
     * @return null|int
     */
    protected function getOptionState(array $options, $default = null)
    {
        if ($default !== null and !is_int($default)) {
            $default = null;
        }

        return (!array_key_exists('state', $options)) ? $default : (int)$options['state'];
    }

    /**
     * Prepare access groups that will be used in a query as filter.
     *
     * @param array $options
     *
     * @return array|null
     */
    protected function getOptionAccessGroups(array $options)
    {
        return (!array_key_exists('access_groups', $options)) ? null : (array)$options['access_groups'];
    }

    /**
     * Prepare an ID that will be used in a query as filter.
     *
     * @param array $options
     * @param string $index
     *
     * @return int
     */
    protected function getOptionId(array $options, $index = 'id')
    {
        return (!array_key_exists($index, $options)) ? 0 : (int)$options[$index];
    }

    /**
     * Prepare IDs that will be used in a query as filter.
     *
     * @param array $options
     * @param string $index
     *
     * @return array
     */
    protected function getOptionIds(array $options, $index = 'ids')
    {
        $ids = (array_key_exists($index, $options) and is_array($options[$index])) ? $options[$index] : array();
        $ids = array_filter(array_unique($ids));
        $ids = ArrayHelper::toInteger($ids);

        return $ids;
    }
}
