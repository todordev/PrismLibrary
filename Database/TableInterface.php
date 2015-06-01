<?php
/**
 * @package         Prism
 * @subpackage      Database\Interfaces
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\Database;

defined('JPATH_PLATFORM') or die;

/**
 * This interface provides methods that should be used for classes,
 * which are based on Data Access Object Pattern.
 *
 * @package         Prism
 * @subpackage      Database\Interfaces
 */
interface TableInterface
{
    public function load($keys, $options = array());
    public function bind($data, $ignore = array());
    public function store();
}
