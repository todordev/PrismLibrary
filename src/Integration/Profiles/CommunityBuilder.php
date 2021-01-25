<?php
/**
 * @package      ITPrism
 * @subpackage   Integrations\Profiles
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Profiles;

use Prism\Library\Prism\Integration\Helper;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality used for integrating
 * extensions with the profile of Community Builder.
 *
 * @package      ITPrism
 * @subpackage   Integrations\Profiles
 */
class CommunityBuilder implements ProfilesInterface
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
     * $profiles = new Prism\Library\Prism\Integration\Profiles\CommunityBuilder(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;

        $this->avatarSizes = array(
            'icon'   => 'tn',
            'small'  => 'tn',
            'medium' => '',
            'large'  => '',
        );
    }

    /**
     * Load data about profiles from database.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Library\Prism\Integration\Profiles\CommunityBuilder(\JFactory::getDbo());
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
                ->select(
                    'a.id AS user_id, a.name, '.
                    'b.avatar, '.
                    $query->concatenate(array('a.id', 'a.username'), ':') . ' AS slug'
                )
                ->from($this->db->quoteName('#__users', 'a'))
                ->innerJoin($this->db->quoteName('#__comprofiler', 'b') . ' ON a.id = b.user_id')
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
     * $profiles = new Prism\Library\Prism\Integration\Profiles\CommunityBuilder(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $avatar = $profiles->getAvatar($userId);
     * </code>
     *
     * @param integer $userId
     * @param string  $size One of the following sizes - icon, small, medium, large.
     * @param bool    $returnDefault Return or not a link to default avatar.
     *
     * @return string
     */
    public function getAvatar($userId, $size = 'small', $returnDefault = true)
    {
        $link = '';
        if (!array_key_exists($userId, $this->profiles)) {
            $link = \JUri::root() . 'components/com_comprofiler/plugin/templates/default/images/avatar/nophoto_n.png';
        } else {
            if (!empty($this->profiles[$userId]->avatar)) {
                $avatarSize = (!array_key_exists($size, $this->avatarSizes)) ? null : $this->avatarSizes[$size];

                $file = trim($this->profiles[$userId]->avatar);
                $link = \JUri::root() . 'images/comprofiler/'  . $avatarSize.$file;

            } else {
                if ($returnDefault) {
                    $link = \JUri::root() . 'components/com_comprofiler/plugin/templates/default/images/avatar/nophoto_n.png';
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
     * $profiles = new Prism\Library\Prism\Integration\Profiles\CommunityBuilder(\JFactory::getDbo());
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

        if (array_key_exists($userId, $this->profiles)) {
            $needles = array(
                'userprofile' => array(0)
            );

            $menuItemId = Helper::getItemId('com_comprofiler', $needles);
            $link = 'index.php?option=com_comprofiler&view=userprofile&user='.(int)$userId;
            if ($menuItemId > 0) {
                $link .= '&Itemid='. (int)$menuItemId;
            }

            // Route the link.
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
     * $profiles = new Prism\Library\Prism\Integration\Profiles\CommunityBuilder(\JFactory::getDbo());
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
     * $profiles = new Prism\Library\Prism\Integration\Profiles\CommunityBuilder(\JFactory::getDbo());
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
