<?php
/**
 * @package         Prism
 * @subpackage      Database\Tables
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database;

use Joomla\Registry\Registry;

defined('JPATH_PLATFORM') or die;

/**
 * This trait provides methods for objects used as tables.
 *
 * @package         Prism
 * @subpackage      Database\Tables
 */
trait TableTrait
{
    /**
     * Object parameters.
     *
     * @var Registry
     */
    protected $params;

    /**
     * Database driver.
     *
     * @var \JDatabaseDriver
     */
    protected $db;

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
     * @param array|\stdClass $data
     * @param array $ignored
     */
    public function bind($data, array $ignored = array())
    {
        // Parse parameters of the object if they exists.
        if (is_array($data)) {
            if (array_key_exists('params', $data) and !in_array('params', $ignored, true)) {
                if ($data['params'] instanceof Registry) {
                    $this->params = $data['params'];
                } else {
                    $this->params = new Registry($data['params']);
                }
                unset($data['params']);
            }

            foreach ($data as $key => $value) {
                if (!in_array($key, $ignored, true)) {
                    $this->$key = $value;
                }
            }
        } elseif (is_object($data)) {
            if (property_exists($data, 'params') and !in_array('params', $ignored, true)) {
                if ($data->params instanceof Registry) {
                    $this->params = $data->params;
                } else {
                    $this->params = new Registry($data->params);
                }
                unset($data->params);
            }

            $data_ = get_object_vars($data);
            foreach ($data_ as $key => $value) {
                if (!in_array($key, $ignored, true)) {
                    $this->$key = $value;
                }
            }
            unset($data_);
        }
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

        if (array_key_exists('db', $vars)) {
            unset($vars['db']);
        }

        if (array_key_exists('params', $vars)) {
            $vars['params'] = $this->getParams();
        }

        foreach ($vars as $key => $v) {
            if (is_object($v) and method_exists($v, 'getProperties')) {
                $vars[$key] = $v->getProperties();
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
        return $this->params->get($index, $default);
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
        $previous             = $this->params->get($index);
        $this->params->set($index, $value);

        return $previous;
    }

    /**
     * Return the parameters of the object.
     *
     * <code>
     * $notification   = new Gamification\Notification(\JFactory::getDbo());
     *
     * $params = $notification->getParams();
     * </code>
     *
     * @return  array
     */
    public function getParams()
    {
        return $this->params->toArray();
    }
}
