<?php
/**
 * @package         Prism
 * @subpackage      Helpers
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Helper;

/**
 * Interface for helper command.
 *
 * @package         Prism
 * @subpackage      Helpers
 */
interface HelperInterface
{
    public function handle(&$data, array $options = array()): void;
}
