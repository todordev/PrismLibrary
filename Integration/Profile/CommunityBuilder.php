<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profile
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profile;

use Prism\Database\TableImmutable;
use Prism\Integration\Helper;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with the profile of Community Builder.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class CommunityBuilder extends TableImmutable implements ProfileInterface
{
    protected $user_id;
    protected $avatar;
    protected $location;
    protected $country_code;
    protected $slug;

    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\CommunityBuilder(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        parent::__construct($db);

        $this->avatarSizes = array(
            'icon'   => 'tn',
            'small'  => 'tn',
            'medium' => '',
            'large'  => '',
        );
    }

    /**
     * Load user data
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\CommunityBuilder(\JFactory::getDbo());
     * $profile->load($userId);
     * </code>
     *
     * @param int|array $keys
     * @param array $options
     */
    public function load($keys, array $options = array())
    {
        $query = $this->db->getQuery(true);
        $query
            ->select(
                'a.id AS user_id, a.name, '.
                'b.avatar, '.
                $query->concatenate(array('a.id', 'a.username'), ':') . ' AS slug'
            )
            ->from($this->db->quoteName('#__users', 'a'))
            ->innerJoin($this->db->quoteName('#__comprofiler', 'b') . ' ON a.id = b.user_id')
            ->where('a.id = ' . (int)$keys);

        $this->db->setQuery($query);
        $result = (array)$this->db->loadAssoc();

        $this->bind($result);
    }

    /**
     * Provide a link to social profile.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\CommunityBuilder(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $link = $profile->getLink();
     * </code>
     *
     * @param bool $route Route or not the link.
     *
     * @return string
     */
    public function getLink($route = true)
    {
        $link = '';
        if (($this->user_id !== null) and ($this->user_id > 0)) {
            $needles = array(
                'userprofile' => array(0)
            );

            $menuItemId = Helper::getItemId('com_comprofiler', $needles);
            $link = 'index.php?option=com_comprofiler&view=userprofile&user='.(int)$this->user_id;
            if ($menuItemId > 0) {
                $link .= '&Itemid='. (int)$menuItemId;
            }

            if (!$route) {
                $link = \JRoute::_($link);
            }
        }

        return $link;
    }

    /**
     * Provide a link to social avatar.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\CommunityBuilder(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $avatar = $profile->getAvatar();
     * </code>
     *
     * @param string $size One of the following sizes - icon, small, medium, large.
     * @param bool $returnDefault Return or not a link to default avatar.
     *
     * @return string
     */
    public function getAvatar($size = 'small', $returnDefault = true)
    {
        $link = '';

        if ($this->avatar !== null) {
            $avatarSize = (!array_key_exists($size, $this->avatarSizes)) ? null : $this->avatarSizes[$size];

            $file = \JString::trim($this->avatar);
            $link = \JUri::root() . 'images/comprofiler/'  . $avatarSize.$file;
        } else {
            if ($returnDefault) {
                $link = \JUri::root() . 'components/com_comprofiler/plugin/templates/default/images/avatar/nophoto_n.png';
            }
        }

        return $link;
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\CommunityBuilder(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $location = $profile->getLocation();
     * </code>
     *
     * @return string
     */
    public function getLocation()
    {
        return '';
    }

    /**
     * Return a country code of a country where the user lives.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\CommunityBuilder(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $countryCode = $profile->getCountryCode();
     * </code>
     *
     * @return string
     */
    public function getCountryCode()
    {
        return '';
    }
}
