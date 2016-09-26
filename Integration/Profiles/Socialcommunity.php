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

jimport('Socialcommunity.init');

/**
 * This class provides functionality used for integrating
 * extensions with the profile of Social Community.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
class Socialcommunity implements ProfilesInterface
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

    protected $mediaUrl;

    /**
     * Initialize the object.
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;

        $this->avatarSizes = array(
            'icon' => array('default' => 'no_profile_24x24.png', 'image' => 'image_icon'),
            'small' => array('default' => 'no_profile_50x50.png', 'image' => 'image_square'),
            'medium' => array('default' => 'no_profile_100x100.png', 'image' => 'image_small'),
            'large' => array('default' => 'no_profile_200x200.png', 'image' => 'image')
        );
    }

    /**
     * Load data about profiles from database.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Integration\Profiles\Socialcommunity(\JFactory::getDbo());
     * $profiles->load(array('ids' => $ids));
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
                ->select(
                    'a.id, a.user_id, a.image_icon, a.image_small, a.image_square, a.image, ' .
                    $query->concatenate(array('a.id', 'a.alias'), ':') . ' AS slug, ' .
                    'b.name as location, b.country_code'
                )
                ->from($this->db->quoteName('#__itpsc_profiles', 'a'))
                ->leftJoin($this->db->quoteName('#__itpsc_locations', 'b') . ' ON a.location_id = b.id')
                ->where('a.user_id IN ( ' . implode(',', $userIds) . ')');

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
     * $profiles = new Prism\Integration\Profiles\Socialcommunity(\JFactory::getDbo());
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
            $link   = \JUri::root() . 'media/com_socialcommunity/images/' . $this->avatarSizes[$size]['default'];
        } else {
            // Get avatar size.
            $avatar = (!array_key_exists($size, $this->avatarSizes)) ? null : $this->avatarSizes[$size]['image'];

            if (!$avatar or !array_key_exists($userId, $this->profiles) or !$this->profiles[$userId]->$avatar) {
                if ($returnDefault) {
                    $avatar = (!array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes['small']['default'] : $this->avatarSizes[$size]['default'];
                    $link   = \JUri::root() . 'media/com_socialcommunity/images/' . $avatar;
                }
            } else {
                $link = $this->mediaUrl . '/user'.$userId.'/' . $this->profiles[$userId]->$avatar;
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
     * $profiles = new Prism\Integration\Profiles\Socialcommunity(\JFactory::getDbo());
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
        if (array_key_exists($userId, $this->profiles) and $this->profiles[$userId]->slug !== '') {
            $link = \SocialcommunityHelperRoute::getProfileRoute($this->profiles[$userId]->slug);

            if ($route) {
                $link = \JRoute::_($link);
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
     * $profiles = new Prism\Integration\Profiles\Socialcommunity(\JFactory::getDbo());
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
        if (!array_key_exists($userId, $this->profiles)) {
            return null;
        } else {
            return $this->profiles[$userId]->location;
        }
    }

    /**
     * Return a country code of a country where the user lives.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\Socialcommunity(\JFactory::getDbo());
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
        if (!array_key_exists($userId, $this->profiles)) {
            return null;
        } else {
            return $this->profiles[$userId]->country_code;
        }
    }

    /**
     * Set the URL to the media folder.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $url = "/images/profiles;
     *
     * $profiles = new Prism\Integration\Profiles\Socialcommunity(\JFactory::getDbo());
     * $profiles->setMediaUrl($url);
     * </code>
     *
     * @param string $url
     * @return self
     */
    public function setMediaUrl($url)
    {
        $this->mediaUrl = $url;

        return $this;
    }

    /**
     * Get the URL to media folder.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Integration\Profiles\Socialcommunity(\JFactory::getDbo());
     * $url = $profiles->getMediaUrl();
     * </code>
     *
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }
}
