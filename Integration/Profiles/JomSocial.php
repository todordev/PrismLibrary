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

\JLoader::register('CRoute', JPATH_ROOT . '/components/com_community/libraries/core.php');

/**
 * This class provides functionality used for integrating
 * extensions with the profile of JomSocial.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
class JomSocial implements ProfilesInterface
{
    protected $profiles = array();

    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array(
        'icon' => 'thumb',
        'small' => 'thumb',
        'medium' => 'avatar',
        'large' => 'avatar',
    );

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
     * $profiles = new Prism\Integration\Profiles\JomSocial(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Load data about profiles from database.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Integration\Profiles\JomSocial(\JFactory::getDbo());
     * $profiles->load($ids);
     * </code>
     *
     * @param array $ids
     */
    public function load(array $ids)
    {
        if (count($ids) > 0) {
            $query = $this->db->getQuery(true);
            $query
                ->select('a.userid AS user_id, a.avatar, a.thumb')
                ->from($this->db->quoteName('#__community_users', 'a'))
                ->where('a.userid IN ( ' . implode(',', $ids) . ')');

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
     * $profiles = new Prism\Integration\Profiles\JomSocial(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $avatar = $profiles->getAvatar($userId);
     * </code>
     * 
     * @param integer $userId
     * @param mixed   $size One of the following sizes - icon, small, medium, large.
     * @param bool   $returnDefault Return or not a link to default avatar.
     *
     * @return string
     */
    public function getAvatar($userId, $size = 'small', $returnDefault = true)
    {
        $link = '';

        if (!array_key_exists($userId, $this->profiles)) {
            $link = \JUri::root() . 'components/com_community/assets/default_thumb.jpg';
        } else {
            // Get avatar size.
            $avatar = (array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes[$size] : null;

            if (!$avatar or empty($this->profiles[$userId]->$avatar)) {
                if ($returnDefault) {
                    $link = \JUri::root() . 'components/com_community/assets/default_thumb.jpg';
                }
            } else {
                $link = \JUri::root() . $this->profiles[$userId]->$avatar;
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
     * $profiles = new Prism\Integration\Profiles\JomSocial(\JFactory::getDbo());
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
            $link = 'index.php?option=com_community&view=profile&userid=' . $this->profiles[$userId]->user_id;

            if ($route) {
                $link = \CRoute::_($link);
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
     * $profiles = new Prism\Integration\Profiles\JomSocial(\JFactory::getDbo());
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
     * $profiles = new Prism\Integration\Profiles\JomSocial(\JFactory::getDbo());
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
