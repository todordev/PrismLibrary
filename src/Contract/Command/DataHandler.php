<?php
/**
 * @package         Prism
 * @subpackage      Helpers
 * @author       FunFex <opensource@funfex.com>
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Command;

/**
 * Interface for helper command.
 *
 * @package         Prism
 * @subpackage      Helpers
 */
interface DataHandler
{
    public function handle(&$data, array $options = array()): void;
}
