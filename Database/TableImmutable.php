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
 * @subpackage      Database\Tables
 */
abstract class TableImmutable implements TableInterface
{
    /**
     * Database driver.
     *
     * @var \JDatabaseDriver
     */
    protected $db;

    /**
     * Object parameters.
     *
     * @var array
     */
    protected $params = array();

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db = null)
    {
        $this->db = $db;
    }

    abstract public function load($keys, $options = array());
    
    final public function store()
    {
        throw new \Exception(\JText::sprintf("LIB_PRISM_ERROR_IMMUTABLE_OBJECT_STORE", get_class($this)));
    }

    /**
     * Set notification data to object parameters.
     *
     * <code>
     * $data = array(
     *        "note"      => "...",
     *        "image"   => "picture.png",
     *        "url"     => "http://itprism.com/",
     *        "user_id" => 1
     * );
     *
     * $notification   = new Gamification\Notification(\JFactory::getDbo());
     * $notification->bind($data);
     * </code>
     *
     * @param array $data
     * @param array $ignored
     */
    public function bind($data, $ignored = array())
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $ignored)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Returns a property of the object or the default value if the property is not set.
     *
     * <code>
     * $notification   = new Gamification\Notification(\JFactory::getDbo());
     *
     * $userId = $notification->get("user_id");
     * </code>
     *
     * @param   string $property The name of the property.
     * @param   mixed  $default  The default value.
     *
     * @return  mixed    The value of the property.
     */
    public function get($property, $default = null)
    {
        if (isset($this->$property)) {
            return $this->$property;
        }

        return $default;
    }

    /**
     * Modifies a property of the object, creating it if it does not already exist.
     *
     * <code>
     * $notification   = new Gamification\Notification(\JFactory::getDbo());
     *
     * $notification->set("user_id", 1);
     * $notification->set("note", "....");
     * </code>
     *
     * @param   string $property The name of the property.
     * @param   mixed  $value    The value of the property to set.
     *
     * @return  mixed  Previous value of the property.
     */
    public function set($property, $value = null)
    {
        $previous        = isset($this->$property) ? $this->$property : null;
        $this->$property = $value;

        return $previous;
    }

    /**
     * Returns an associative array of object properties.
     *
     * <code>
     * $notification   = new Gamification\Notification(\JFactory::getDbo());
     *
     * $properties = $notification->getProperties();
     * </code>
     *
     * @return  array
     */
    public function getProperties()
    {
        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (strcmp('db', $key) == 0) {
                unset($vars[$key]);
            }
        }

        return $vars;
    }

    /**
     * Returns a parameter of the object or the default value if the parameter is not set.
     *
     * <code>
     * $notification   = new Gamification\Notification(\JFactory::getDbo());
     *
     * $userId = $notification->getParam("user_id");
     * </code>
     *
     * @param   string $index The name of the index.
     * @param   mixed  $default  The default value.
     *
     * @return  mixed    The value of the property.
     */
    public function getParam($index, $default = null)
    {
        if (isset($this->params[$index])) {
            return $this->params[$index];
        }

        return $default;
    }

    /**
     * Modifies a parameter of the object, creating it if it does not already exist.
     *
     * <code>
     * $notification   = new Gamification\Notification(\JFactory::getDbo());
     *
     * $notification->set("user_id", 1);
     * $notification->set("note", "....");
     * </code>
     *
     * @param   string $index    The name of the parameter.
     * @param   mixed  $value    The value of the parameter to set.
     *
     * @return  mixed  Previous value of the parameter.
     */
    public function setParam($index, $value = null)
    {
        $previous             = isset($this->params[$index]) ? $this->params[$index] : null;
        $this->params[$index] = $value;

        return $previous;
    }
}
