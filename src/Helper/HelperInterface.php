<?php
/**
 * @package         Prism
 * @subpackage      Helpers
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
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
