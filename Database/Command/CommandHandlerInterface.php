<?php
/**
 * @package         Prism
 * @subpackage      Database\Commands
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database\Command;

defined('JPATH_PLATFORM') or die;

/**
 * Interface for command handler.
 *
 * @package         Prism
 * @subpackage      Database\Commands
 */
interface CommandHandlerInterface
{
    public function addCommand(CommandAbstract $command, $index = '');
    public function removeCommand($index);
    public function removeCommands();
    public function handle(array $options = array());
}
