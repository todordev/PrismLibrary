<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profiles;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality used for integrating
 * extensions with the profile of Gravatar.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
class Gravatar implements ProfilesInterface
{
    protected $profiles = array();

    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array();

    /**
     * Database driver
     *
     * @var \JDatabaseDriver
     */
    protected $db;

    /**
     * Initialize the object
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Integration\Profiles\Gravatar(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;

        $this->avatarSizes = array(
            'icon' => '40',
            'small' => '80',
            'medium' => '160',
            'large' => '200',
        );
    }

    /**
     * Load data about profiles from database.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Integration\Profiles\Gravatar(\JFactory::getDbo());
     * $profiles->load($ids);
     * </code>
     *
     * @param array $userIds
     *
     * @throws \RuntimeException
     */
    public function load(array $userIds)
    {
        if (count($userIds) > 0) {
            $query = $this->db->getQuery(true);
            $query
                ->select('a.id AS user_id, a.email, MD5(a.email) as hash')
                ->from($this->db->quoteName('#__users', 'a'))
                ->where('a.id IN ( ' . implode(',', $userIds) . ')');

            $this->db->setQuery($query);
            $this->profiles = (array)$this->db->loadObjectList('user_id');
        }
    }

    /**
     * Get a link to user avatar.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\Gravatar(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $avatar = $profiles->getAvatar($userId);
     * </code>
     *
     * @param integer $userId
     * @param mixed   $size One of the following sizes - icon, small, medium, large.
     * @param bool   $returnDefault
     *
     * @return string
     */
    public function getAvatar($userId, $size = 'small', $returnDefault = true)
    {
        if (!array_key_exists($userId, $this->profiles)) {
            $link = '';
        } else {
            $link = 'http://www.gravatar.com/avatar/' . $this->profiles[$userId]->hash;
            $avatarSize = (!array_key_exists($size, $this->avatarSizes)) ? null : (int)$this->avatarSizes[$size];
            if ($avatarSize !== null) {
                $link .= '?s=' . $avatarSize;
            }
        }

        return $link;
    }

    /**
     * Get a link to user profile.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\Gravatar(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $link = $profiles->getLink($userId);
     * </code>
     *
     * @param int $userId
     * @param bool $route Route or not the link.
     *
     * @return string
     */
    public function getLink($userId, $route = true)
    {
        return 'javascript:void(0)';
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\Gravatar(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $location = $profiles->getLocation($userId);
     * </code>
     *
     * @param int $userId
     *
     * @return string
     */
    public function getLocation($userId)
    {
        return '';
    }

    /**
     * Return a country code of a country where the user lives.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\Gravatar(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $countryCode = $profiles->getCountryCode($userId);
     * </code>
     *
     * @param int $userId
     * @return string
     */
    public function getCountryCode($userId)
    {
        return '';
    }
}
