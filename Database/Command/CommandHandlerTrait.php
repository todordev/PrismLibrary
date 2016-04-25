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
 * Trait for command handler.
 *
 * @package         Prism
 * @subpackage      Database\Commands
 */
trait CommandHandlerTrait
{
    protected $commands = array();

    /**
     * Add a command that will be executed to prepare the object.
     *
     * <code>
     * $command  = new Userideas\Comment\Command\CommandLoadByUsersIds(\JFactory::getDbo());
     * $comments = new Userideas\Comment\Comments(\JFactory::getDbo());
     * $comments->addCommand($command);
     * </code>
     *
     * @param CommandAbstract $command
     * @param string $index
     */
    public function addCommand(CommandAbstract $command, $index = '')
    {
        if ($index !== '') {
            $this->commands[$index] = $command;
        } else {
            $this->commands[] = $command;
        }
    }

    /**
     * Remove a command.
     *
     * <code>
     * $options = array(
     *    'start'           => 0,
     *    'limit'           => 10,
     *    'order_column'    => 'DESC',
     *    'order_direction' => 'DESC',
     *    'ids'             => array(1,2,3,4)
     * );
     *
     * $command  = new Userideas\Comment\Command\CommandLoadByUsersIds(\JFactory::getDbo());
     * $comments = new Userideas\Comment\Comments(\JFactory::getDbo());
     * $comments->addCommand($command, 'load_by_users_ids');
     *
     * $comments->handle($options);
     * $comments->removeCommand('load_by_users_ids');
     * </code>
     *
     * @param string $index
     */
    public function removeCommand($index)
    {
        if (array_key_exists($index, $this->commands)) {
            unset($this->commands[$index]);
        }
    }

    /**
     * Remove all commands.
     *
     * <code>
     * $options = array(
     *    'start'           => 0,
     *    'limit'           => 10,
     *    'order_column'    => 'DESC',
     *    'order_direction' => 'DESC',
     *    'ids'             => array(1,2,3,4)
     * );
     *
     * $command1  = new Userideas\Comment\Command\CommandLoadByUsersIds(\JFactory::getDbo());
     * $command2  = new Userideas\Comment\Command\CommandPrepareStatuses(\JFactory::getDbo());
     *
     * $comments = new Userideas\Comment\Comments(\JFactory::getDbo());
     * $comments->addCommand($command1);
     * $comments->addCommand($command2);
     *
     * $comments->handle($options);
     * $comments->removeCommands();
     * </code>
     */
    public function removeCommands()
    {
        $this->commands = array();
    }

    /**
     * Handle command that will preparing the object.
     *
     * <code>
     * $options = array(
     *    'start'           => 0,
     *    'limit'           => 10,
     *    'order_column'    => 'DESC',
     *    'order_direction' => 'DESC',
     *    'ids'             => array(1,2,3,4)
     * );
     *
     * $command  = new Userideas\Comment\Command\CommandLoadByUsersIds(\JFactory::getDbo());
     * $comments = new Userideas\Comment\Comments(\JFactory::getDbo());
     * $comments->addCommand($command);
     * $comments->handle($options);
     * </code>
     *
     * @param array $options
     */
    public function handle(array $options = array())
    {
        /** @var CommandAbstract $command */
        foreach ($this->commands as $command) {
            $command->handle($this, $options);
        }
    }
}
