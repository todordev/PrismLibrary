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
abstract class TableImmutable
{
    use TableTrait;

    /**
     * Flag that show us if the current object has been initialized by the method bind().
     *
     * @var bool
     */
    protected $bound = false;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db = null)
    {
        $this->db     = $db;
        $this->params = new Registry;
    }

    abstract public function load($keys, array $options = array());

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
     *
     * @return self
     */
    public function bind($data, array $ignored = array())
    {
        if (!$this->bound) {
            // Parse parameters of the object if they exists.
            if (array_key_exists('params', $data) and !in_array('params', $ignored, true)) {
                $this->params = new Registry($data['params']);
                unset($data['params']);
            }

            foreach ($data as $key => $value) {
                if (!in_array($key, $ignored, true)) {
                    $this->$key = $value;
                }
            }

            $this->bound = true;

            return $this;
        } else { // Create new object if it is already bound.

            $newObject = new $this($this->db);
            /** @var $newObject TableImmutable */

            $newObject->bind($data, $ignored);

            return $newObject;
        }
    }
}
