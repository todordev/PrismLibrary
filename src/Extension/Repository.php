<?php
/**
 * @package      Prism
 * @subpackage   Extensions
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Extension;

use Joomla\Database\DatabaseDriver;
use Prism\Library\Prism\Constant\State;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing extensions.
 *
 * @package     Prism
 * @subpackage  Extensions
 */
class Repository
{
    protected array $extensions = [];

    /**
     * Database driver.
     *
     * @var DatabaseDriver
     */
    protected DatabaseDriver $db;

    /**
     * Initialize the object.
     *
     * <code>
     * $extensions = array(
     *     "com_crowdfunding",
     *     "com_gamification"
     * );
     *
     * $repository = new Prism\Library\Prism\Extensions\Repository(Factory::getDbo(), $extensions);
     * </code>
     *
     * @param DatabaseDriver $db Database driver.
     * @param array $extensions A list with extensions name.
     */
    public function __construct(DatabaseDriver $db, array $extensions)
    {
        $this->db = $db;
        $this->extensions = $extensions;
    }

    /**
     * Return a list with names of enabled extensions.
     *
     * <code>
     * $extensions = array(
     *     "com_crowdfunding",
     *     "com_gamification"
     * );
     *
     * $repository = new Prism\Library\Prism\Extensions\Repository(Factory::getDbo(), $extensions);
     * $enabledExtensions = $repository->fetchEnabledExtensions();
     * </code>
     *
     * @return array
     */
    public function fetchEnabledExtensions(): array
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
            ->where('a.enabled = ' . State::ENABLED);

        $this->db->setQuery($query);
        $extensions = (array)$this->db->loadColumn();

        return $extensions;
    }
}
