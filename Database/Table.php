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
 * This class contains methods that are used for handling objects as array.
 * The data has to be loaded from database.
 *
 * @package         Prism
 * @subpackage      Database\Tables
 */
abstract class Table
{
    use TableTrait;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db = null)
    {
        $this->db = $db;
        $this->params = new Registry;
    }

    abstract public function load($keys, array $options = array());
    abstract public function store();

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

        if (array_key_exists('db', $parameters)) {
            unset($parameters['db']);
        }

        if (array_key_exists('params', $parameters)) {
            unset($parameters['params']);
            $this->params = new Registry;
        }

        foreach ($parameters as $key => $value) {
            $this->$key = null;
        }
    }
}
