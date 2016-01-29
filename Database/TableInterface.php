<?php
/**
 * @package         Prism
 * @subpackage      Database\Interfaces
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
 * @subpackage      Database\Interfaces
 *
 * @deprecated v1.15
 */
interface TableInterface
{
    public function load($keys, $options = array());
    public function bind($data, $ignore = array());
    public function store();
}
