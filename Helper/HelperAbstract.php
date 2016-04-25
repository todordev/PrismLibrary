<?php
/**
 * @package         Prism
 * @subpackage      Helpers
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Helper;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to manage helper command.
 * It should be used when do functionality that interact with database.
 *
 * @package         Prism
 * @subpackage      Helpers
 */
abstract class HelperAbstract implements HelperInterface
{
    /**
     * Database driver.
     *
     * @var \JDatabaseDriver
     */
    protected $db;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db = null)
    {
        $this->db = $db;
    }

    abstract public function handle(&$data, array $options = array());
}
