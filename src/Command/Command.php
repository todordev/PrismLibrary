<?php
/**
 * @package         Prism
 * @subpackage      Commands
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Command;

/**
 * Interface for a command.
 *
 * @package         Prism
 * @subpackage      Commands
 */
interface Command
{
    public function handle();
}
