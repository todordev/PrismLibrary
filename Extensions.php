<?php
/**
 * @package      Prism
 * @subpackage   Extensions
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing extensions.
 *
 * @package     Prism
 * @subpackage  Extensions
 */
class Extensions
{
    protected $extensions = array();

    /**
     * Database driver.
     *
     * @var \JDatabaseDriver
     */
    protected $db;

    /**
     * Initialize the object.
     *
     * <code>
     * $extensionsNames = array(
     *     "com_crowdfunding",
     *     "com_gamification"
     * );
     *
     * $extensions = new Prism\Extensions(\JFactory::getDbo(), $extensionsNames);
     * </code>
     *
     * @param \JDatabaseDriver $db         Database driver.
     * @param array           $extensions A list with extensions name.
     */
    public function __construct(\JDatabaseDriver $db, array $extensions)
    {
        $this->db         = $db;
        $this->extensions = $extensions;
    }

    /**
     * Return a list with names of enabled extensions.
     *
     * <code>
     * $extensionsNames = array(
     *     "com_crowdfunding",
     *     "com_gamification"
     * );
     *
     * $extensions = new Prism\Extensions(\JFactory::getDbo(), $extensionsNames);
     *
     * $enabled = $extensions->getEnabled();
     * </code>
     *
     * @return array
     */
    public function getEnabled()
    {
        $extensions = array();

        if (!$this->extensions) {
            return $extensions;
        }

        foreach ($this->extensions as $extension) {
            $extensions[] = $this->db->quote($extension);
        }

        $query = $this->db->getQuery(true);
        $query
            ->select('a.element')
            ->from($this->db->quoteName('#__extensions', 'a'))
            ->where('a.element IN (' . implode(',', $extensions) . ')')
            ->where('a.enabled = 1');

        $this->db->setQuery($query);
        $extensions = (array)$this->db->loadColumn();

        return $extensions;
    }
}
