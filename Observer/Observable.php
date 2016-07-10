<?php
/**
 * @package         Prism
 * @subpackage      Observers
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Observer;

defined('JPATH_PLATFORM') or die;

/**
 * This is abstract class of observable object.
 *
 * @package         Prism
 * @subpackage      Observers
 */
abstract class Observable implements \JObservableInterface
{
    /**
     * Database driver.
     *
     * @var \JDatabaseDriver
     */
    protected $db;

    /**
     * @var \JObserverUpdater
     */
    protected $observers;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;

        // Implement JObservableInterface:
        // Create observer updater and attaches all observers interested by $this class:
        $this->observers = new \JObserverUpdater($this);
        \JObserverMapper::attachAllObservers($this);
    }

    /**
     * Set database object.
     *
     * <code>
     * $observableObject   = new Prism\Observable();
     * $observableObject->setDb(\JFactory::getDbo());
     * </code>
     *
     * @param \JDatabaseDriver $db
     */
    public function setDb(\JDatabaseDriver $db)
    {
        $this->db = $db;
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
