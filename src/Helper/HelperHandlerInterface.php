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
 * Interface for helper command handler.
 *
 * @package         Prism
 * @subpackage      Helpers
 */
interface HelperHandlerInterface
{
    public function addCommand(HelperInterface $command, $index = '');
    public function removeCommand($index);
    public function removeCommands();
    public function handle(array $options = array());
}
