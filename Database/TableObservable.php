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
abstract class TableObservable implements TableInterface, \JObservableInterface
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
     * @var \JObserverUpdater
     */
    protected $observers;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db = null)
    {
        $this->db = $db;

        // Implement JObservableInterface:
        // Create observer updater and attaches all observers interested by $this class:
        $this->observers = new \JObserverUpdater($this);
        \JObserverMapper::attachAllObservers($this);
    }

    abstract public function load($keys, $options = array());
    abstract public function store();

    /**
     * Set database object.
     *
     * <code>
     * $notification   = new Gamification\Notification();
     * $notification->setDb(\JFactory::getDbo());
     * </code>
     *
     * @param \JDatabaseDriver $db
     */
    public function setDb(\JDatabaseDriver $db)
    {
        $this->db = $db;
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
            if (!in_array($key, $ignored, true)) {
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
            if (strcmp('db', $key) === 0) {
                unset($vars[$key]);
            }
        }

        return $vars;
    }

    /**
     * Reset the properties of the object.
     *
     * <code>
     * $notificationId = 1;
     *
     * $notification   = new Gamification\Notification(\JFactory::getDbo());
     * $notification->load($notificationId);
     *
     * if (...) {
     *    $notification->reset();
     * }
     * </code>
     */
    public function reset()
    {
        $parameters = get_object_vars($this);
        foreach ($parameters as $key) {
            if (is_string($key) and strcmp('db', $key) === 0) {
                continue;
            }

            $this->$key = null;
        }
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
        if (array_key_exists($index, $this->params)) {
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
        $previous             = (!array_key_exists($index, $this->params)) ? null : $this->params[$index];
        $this->params[$index] = $value;

        return $previous;
    }

    /**
     * Implement JObservableInterface:
     * Adds an observer to this instance.
     * This method will be called from the constructor of classes implementing JObserverInterface
     * which is instantiated by the constructor of $this with JObserverMapper::attachAllObservers($this)
     *
     * @param   \JObserverInterface|\JTableObserver  $observer  The observer object
     *
     * @return  void
     *
     * @since   3.1.2
     */
    public function attachObserver(\JObserverInterface $observer)
    {
        $this->observers->attachObserver($observer);
    }

    /**
     * Gets the instance of the observer of class $observerClass
     *
     * @param   string  $observerClass  The observer class-name to return the object of
     *
     * @return  \JTableObserver|null
     *
     * @since   3.1.2
     */
    public function getObserverOfClass($observerClass)
    {
        return $this->observers->getObserverOfClass($observerClass);
    }
}
