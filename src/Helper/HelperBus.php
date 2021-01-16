<?php
/**
 * @package         Prism
 * @subpackage      Helpers
 * @author       FunFex <opensource@funfex.com>
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Helper;

use Prism\Library\Prism\Contract\Command\DataHandler;

/**
 * Helper command bus class.
 *
 * @package         Prism
 * @subpackage      Helpers
 */
class HelperBus
{
    protected array $commands = [];

    /**
     * This variable contains the data that should be processed by helper commands.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Initialize the object.
     *
     * @param array commands
     */
    public function __construct(array $commands = [])
    {
        $this->commands = $commands;
    }

    /**
     * Add a command that will be executed preparing an object.
     * <code>
     * $helperBus     = new Prism\Library\Prism\Helper\HelperBus($this->items);
     * $helperBus->addCommand(new Userideas\Helper\PrepareParams(), 'prepare_params');
     * $helperBus->addCommand(new Userideas\Helper\PrepareStatuses(), 'prepare_statuses');
     * </code>
     *
     * @param DataHandler $command
     * @param string $index
     */
    public function addCommand(DataHandler $command, $index = ''): void
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
     * $helperBus     = new Prism\Library\Prism\Helper\HelperBus($this->items);
     * $helperBus->addCommand(new Userideas\Helper\PrepareParams(), 'prepare_params');
     * $helperBus->addCommand(new Userideas\Helper\PrepareStatuses(), 'prepare_statuses');
     *
     * $comments->handle($options);
     * $comments->removeCommand('prepare_params');
     * </code>
     *
     * @param string $index
     */
    public function removeCommand(string $index): void
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
     * $helperBus     = new Prism\Library\Prism\Helper\HelperBus($this->items);
     * $helperBus->addCommand(new Userideas\Helper\PrepareParams());
     * $helperBus->addCommand(new Userideas\Helper\PrepareStatuses());
     *
     * $comments->handle($options);
     * $comments->removeCommands();
     * </code>
     */
    public function removeCommands(): void
    {
        $this->commands = array();
    }

    /**
     * Handle command that will preparing the object.
     *
     * <code>
     * $options = array();
     *
     * $helperBus     = new Prism\Library\Prism\Helper\HelperBus($this->items);
     * $helperBus->addCommand(new Userideas\Helper\PrepareParams());
     * $helperBus->addCommand(new Userideas\Helper\PrepareStatuses());
     * $helperBus->addCommand(new Userideas\Helper\PrepareAccess(JFactory::getUser()));
     * $helperBus->handle($options);
     * </code>
     *
     * @param array $options
     */
    public function handle(array $options = array()): void
    {
        /** @var DataHandler $command */
        foreach ($this->commands as $command) {
            $command->handle($this->data, $options);
        }
    }
}
