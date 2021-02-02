<?php
/**
 * @package      Prism
 * @subpackage   Extensions
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Extension;

use Joomla\Database\DatabaseDriver;
use Prism\Library\Prism\Constant\State;

/**
 * This class contains methods that are used for managing extensions.
 *
 * @package     Prism\Library\Prism\Extension
 */
class Repository
{

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
     * $repository = new Repository(Factory::getDbo(), $extensions);
     * </code>
     *
     * @param DatabaseDriver $db Database driver.
     */
    public function __construct(DatabaseDriver $db)
    {
        $this->db = $db;
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
     * $repository = new Repository(Factory::getDbo());
     * $enabledExtensions = $repository->fetchEnabledExtensions($extensions);
     * </code>
     *
     * @return array
     */
    public function fetchEnabledExtensions(array $extensions = []): array
    {
        $results = [];
        if (!$extensions) {
            return $results;
        }

        $query = $this->db->getQuery(true);
        $query
            ->select('a.element')
            ->from($this->db->quoteName('#__extensions', 'a'))
            ->where('a.element IN (' . implode(',', $this->db->quote($extensions)) . ')')
            ->where('a.enabled = ' . State::ENABLED);

        $this->db->setQuery($query);
        $results = (array)$this->db->loadColumn();

        return $results;
    }
}
