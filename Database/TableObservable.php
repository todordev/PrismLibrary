<?php
/**
 * @package         Prism
 * @subpackage      Database\Tables
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database;

use Joomla\Registry\Registry;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for handling objects as array.
 * The data has to be loaded from database.
 *
 * @package         Prism
 * @subpackage      Database\Tables
 */
abstract class TableObservable extends Table implements \JObservableInterface
{
    /**
     * @var \JObserverUpdater
     */
    protected $observers;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db = null)
    {
        parent::__construct($db);

        // Implement JObservableInterface:
        // Create observer updater and attaches all observers interested by $this class:
        $this->observers = new \JObserverUpdater($this);
        \JObserverMapper::attachAllObservers($this);
    }

    /**
     * Implement JObservableInterface:
     * Adds an observer to this instance.
     * This method will be called from the constructor of classes implementing JObserverInterface
     * which is instantiated by the constructor of $this with JObserverMapper::attachAllObservers($this)
     *
     * @param   \JObserverInterface|\JTableObserver  $observer  The observer object
     *
     * @return  void
     *
     * @since   3.1.2
     */
    public function attachObserver(\JObserverInterface $observer)
    {
        $this->observers->attachObserver($observer);
    }

    /**
     * Gets the instance of the observer of class $observerClass
     *
     * @param   string  $observerClass  The observer class-name to return the object of
     *
     * @return  \JTableObserver|null
     *
     * @since   3.1.2
     */
    public function getObserverOfClass($observerClass)
    {
        return $this->observers->getObserverOfClass($observerClass);
    }
}
