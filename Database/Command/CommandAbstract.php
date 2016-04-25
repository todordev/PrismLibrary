<?php
/**
 * @package         Prism
 * @subpackage      Database\Commands
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database\Command;

use Prism\Database\CollectionTrait;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to manage a command handled by collection.
 *
 * @package         Prism
 * @subpackage      Database\Commands
 */
abstract class CommandAbstract
{
    use CollectionTrait;

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

    abstract public function handle(&$object, array $options = array());
}
