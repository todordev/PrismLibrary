<?php
/**
 * @package         Prism
 * @subpackage      Database\Tables
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database;

defined('JPATH_PLATFORM') or die;

/**
 * This interface provides methods that should be used for classes,
 * which are based on Data Access Object Pattern.
 *
 * @package         Prism
 * @subpackage      Database\Tables
 */
interface TableInterface
{
    public function load($keys, array $options = array());
    public function bind($data, array $ignore = array());
    public function store();
}
