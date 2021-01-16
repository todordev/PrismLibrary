<?php
/**
 * @package         Prism
 * @subpackage      Commands
 * @author       FunFex <opensource@funfex.com>
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Command;

/**
 * Interface for a simple command handler.
 *
 * @package         Prism
 * @subpackage      Commands
 */
interface Command
{
    public function handle();
}
