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
 * Trait for helper command.
 *
 * @package         Prism
 * @subpackage      Helpers
 */
trait HelperHandlerTrait
{
    protected $commands = array();

    /**
     * This variable contains the data that should be processed by helper commands.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Add a command that will be executed preparing an object.
     *
     * <code>
     * $helperBus     = new Prism\Helper\HelperBus($this->items);
     * $helperBus->addCommand(new Userideas\Helper\PrepareParams(), 'prepare_params');
     * $helperBus->addCommand(new Userideas\Helper\PrepareStatuses(), 'prepare_statuses');
     * </code>
     *
     * @param HelperInterface $command
     * @param string $index
     */
    public function addCommand(HelperInterface $command, $index = '')
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
     * $options = array();
     *
     * $helperBus     = new Prism\Helper\HelperBus($this->items);
     * $helperBus->addCommand(new Userideas\Helper\PrepareParams(), 'prepare_params');
     * $helperBus->addCommand(new Userideas\Helper\PrepareStatuses(), 'prepare_statuses');
     *
     * $comments->handle($options);
     * $comments->removeCommand('prepare_params');
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
     * $options = array();
     *
     * $helperBus     = new Prism\Helper\HelperBus($this->items);
     * $helperBus->addCommand(new Userideas\Helper\PrepareParams());
     * $helperBus->addCommand(new Userideas\Helper\PrepareStatuses());
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
     * $options = array();
     *
     * $helperBus     = new Prism\Helper\HelperBus($this->items);
     * $helperBus->addCommand(new Userideas\Helper\PrepareParams());
     * $helperBus->addCommand(new Userideas\Helper\PrepareStatuses());
     * $helperBus->addCommand(new Userideas\Helper\PrepareAccess(JFactory::getUser()));
     * $helperBus->handle($options);
     * </code>
     *
     * @param array $options
     */
    public function handle(array $options = array())
    {
        /** @var HelperInterface $command */
        foreach ($this->commands as $command) {
            $command->handle($this->data, $options);
        }
    }
}
