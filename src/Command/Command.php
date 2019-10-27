<?php
/**
 * @package         Prism
 * @subpackage      Commands
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Command;

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
