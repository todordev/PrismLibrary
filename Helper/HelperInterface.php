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
 * Interface for helper command.
 *
 * @package         Prism
 * @subpackage      Helpers
 */
interface HelperInterface
{
    public function handle(&$data, array $options = array());
}
