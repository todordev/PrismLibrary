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
 * extensions with the profile of Kunena.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
class Kunena implements ProfilesInterface
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
     * $profiles = new Prism\Integration\Profiles\Kunena(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;

        $this->avatarSizes = array(
            'icon' => array('folder' => 'size36', 'noimage' => 's_nophoto.jpg'),
            'small' => array('folder' => 'size72', 'noimage' => 's_nophoto.jpg'),
            'medium' => array('folder' => 'size72', 'noimage' => 'nophoto.jpg'),
            'large' => array('folder' => 'size200', 'noimage' => 'nophoto.jpg'),
        );
    }

    /**
     * Load data about profiles from database.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Integration\Profiles\Kunena(\JFactory::getDbo());
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
            // Create a new query object.
            $query = $this->db->getQuery(true);
            $query
                ->select('a.userid AS user_id, a.avatar')
                ->from($this->db->quoteName('#__kunena_users', 'a'))
                ->where('a.userid IN ( ' . implode(',', $userIds) . ')');

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
     * $profiles = new Prism\Integration\Profiles\Kunena(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $avatar = $profiles->getAvatar($userId);
     * </code>
     *
     * @param integer $userId
     * @param string   $size One of the following sizes - icon, small, medium, large.
     * @param bool   $returnDefault Return or not a link to default avatar.
     *
     * @return string
     */
    public function getAvatar($userId, $size = 'small', $returnDefault = true)
    {
        $link = '';

        if (!array_key_exists($userId, $this->profiles)) {
            $link = \JUri::root() . 'media/kunena/avatars/' . $this->avatarSizes['small']['noimage'];
        } else {
            // Get avatar size.
            if (!empty($this->profiles[$userId]->avatar)) {
                $folder = (!array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes['small']['folder'] : $this->avatarSizes[$size]['folder'];
                $link = \JUri::root() . 'media/kunena/avatars/resized/' . $folder . '/'. $this->profiles[$userId]->avatar;
            } else {
                if ($returnDefault) {
                    $noImage = (!array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes['small']['noimage'] : $this->avatarSizes[$size]['noimage'];
                    $link = \JUri::root() . 'media/kunena/avatars/' . $noImage;
                }
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
     * $profiles = new Prism\Integration\Profiles\Kunena(\JFactory::getDbo());
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
        $link = '';
        if (array_key_exists($userId, $this->profiles) and !empty($this->profiles[$userId]->user_id)) {
            $link = 'index.php?option=com_kunena&view=profile&userid=' . (int)$this->profiles[$userId]->user_id;

            if ($route) {
                $link = \KunenaRoute::_($link, false);
            }
        }

        return $link;
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\Kunena(\JFactory::getDbo());
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
     * $profiles = new Prism\Integration\Profiles\Kunena(\JFactory::getDbo());
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
