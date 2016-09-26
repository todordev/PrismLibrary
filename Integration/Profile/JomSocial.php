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

defined('JPATH_PLATFORM') or die;

\JLoader::register('CRoute', JPATH_ROOT . '/components/com_community/libraries/core.php');

/**
 * This class provides functionality to
 * integrate extensions with the profile of JomSocial.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class JomSocial extends TableImmutable implements ProfileInterface
{
    protected $user_id;
    protected $avatar;
    protected $location;
    protected $country;
    protected $country_code;

    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array();

    /**
     * Initialize the object
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\JomSocial(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        parent::__construct($db);

        $this->avatarSizes = array(
            'icon' => 'thumb',
            'small' => 'thumb',
            'medium' => 'avatar',
            'large' => 'avatar',
        );
    }

    /**
     * Load user data
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\JomSocial(\JFactory::getDbo());
     * $profile->load($userId);
     * </code>
     *
     * @param array $keys
     * @param array $options
     *
     * @throws \RuntimeException
     */
    public function load($keys, array $options = array())
    {
        $query = $this->db->getQuery(true);
        $query
            ->select('a.userid AS user_id, a.avatar, a.thumb')
            ->from($this->db->quoteName('#__community_users', 'a'))
            ->where('a.userid = ' . (int)$keys);

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
     * $profile = new Prism\Integration\Profile\JomSocial(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $link = $profile->getLink();
     * </code>
     *
     * @param bool $route Route or not the link.
     *
     * @return string Return a link to the profile.
     */
    public function getLink($route = true)
    {
        $link = '';
        if ($this->user_id !== null) {
            $link = 'index.php?option=com_community&view=profile&userid=' . (int)$this->user_id;

            if ($route) {
                $link = \CRoute::_($link);
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
     * $profile = new Prism\Integration\Profile\JomSocial(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $avatar = $profile->getAvatar();
     * </code>
     *
     * @param string $size  One of the following sizes - icon, small, medium, large.
     * @param bool   $returnDefault Return or not a link to default avatar.
     *
     * @return string Return a link to the picture.
     */
    public function getAvatar($size = 'small', $returnDefault = true)
    {
        // Get avatar size.
        $avatar = (!array_key_exists($size, $this->avatarSizes)) ? null : $this->avatarSizes[$size];

        $link = '';

        if ($avatar === null or \JString::strlen($this->$avatar) === 0) {
            if ($returnDefault) {
                $link = \JUri::root() . 'components/com_community/assets/default_thumb.jpg';
            }
        } else {
            $link = \JUri::root() . $this->$avatar;
        }

        return $link;
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\JomSocial(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $location = $profile->getLocation();
     * </code>
     *
     * @throws \RuntimeException
     * @return string
     */
    public function getLocation()
    {
        if ($this->location === null) {
            $result = '';

            $query = $this->db->getQuery(true);

            $query
                ->select('a.id')
                ->from($this->db->quoteName('#__community_fields', 'a'))
                ->where('a.type =  ' . $this->db->quote('country'));

            $this->db->setQuery($query);
            $typeId = (int)$this->db->loadResult();

            if ($typeId > 0) {
                $query = $this->db->getQuery(true);

                $query
                    ->select('a.value')
                    ->from($this->db->quoteName('#__community_fields_values', 'a'))
                    ->where('a.user_id =  ' . (int)$this->user_id)
                    ->where('a.field_id =  ' . (int)$typeId);

                $this->db->setQuery($query);
                $result = $this->db->loadResult();

                if (!$result) { // Set values to variables
                    $result = '';
                }
            }

            $this->location = $result;
        }

        return \JText::_($this->location);
    }

    /**
     * Return a country code of a country where the user lives.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\JomSocial(\JFactory::getDbo());
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
