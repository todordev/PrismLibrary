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

jimport('Socialcommunity.init');

/**
 * This class provides functionality to
 * integrate extensions with the profile of Social Community.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class Socialcommunity extends TableImmutable implements ProfileInterface
{
    protected $id;
    protected $user_id;
    protected $image_icon;
    protected $image_small;
    protected $image_square;
    protected $image;
    protected $location;
    protected $country_code;
    protected $slug;
    protected $active;
    protected $mediaUrl;

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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
     * </code>
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        parent::__construct($db);

        $this->avatarSizes = array(
            'icon' => 'image_icon',
            'small' => 'image_square',
            'medium' => 'image_small',
            'large' => 'image',
        );
    }

    /**
     * Load user data
     *
     * <code>
     * $keys = array(
     *     'user_id' => $userId
     * );
     *
     * $profile = new Prism\Integration\Profile\Socialcommunity(\JFactory::getDbo());
     * $profile->load($keys);
     * </code>
     *
     * @param array $keys
     * @param array $options
     */
    public function load($keys, array $options = array())
    {
        $query = $this->db->getQuery(true);
        $query
            ->select(
                'a.id, a.user_id, a.image_icon, a.image_small, a.image_square, a.image, a.active, ' .
                $query->concatenate(array('a.id', 'a.alias'), ':') . ' AS slug, ' .
                'b.name as location, b.country_code'
            )
            ->from($this->db->quoteName('#__itpsc_profiles', 'a'))
            ->leftJoin($this->db->quoteName('#__itpsc_locations', 'b') . ' ON a.location_id = b.id');

        // Filter by keys.
        if (!is_array($keys)) {
            $query->where('a.id = ' . (int)$keys);
        } else {
            foreach ($keys as $key => $value) {
                $query->where($this->db->quoteName('a.'.$key) . ' = ' . $this->db->quote($value));
            }
        }

        $this->db->setQuery($query);
        $result = (array)$this->db->loadAssoc();

        $this->bind($result);
    }

    /**
     * Provide a link to social profile.
     *
     * <code>
     * $keys = array(
     *     'user_id' => $userId
     * );
     *
     * $profile = new Prism\Integration\Profile\Socialcommunity(\JFactory::getDbo());
     * $profile->load($keys);
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
        if ($this->slug !== '') {
            $link = \SocialcommunityHelperRoute::getProfileRoute($this->slug);

            if ($route) {
                $link = \JRoute::_($link);
            }
        }

        return $link;
    }

    /**
     * Provide a link to social avatar.
     *
     * <code>
     * $keys = array(
     *     'user_id' => $userId
     * );
     *
     * $profile = new Prism\Integration\Profile\Socialcommunity(\JFactory::getDbo());
     * $profile->load($keys);
     *
     * $avatar = $profile->getAvatar();
     * </code>
     *
     * @param string $size One of the following sizes - icon, small, medium, large.
     * @param bool   $returnDefault Return or not a link to default avatar.
     *
     * @return string
     */
    public function getAvatar($size = 'small', $returnDefault = true)
    {
        // Get avatar size.
        $avatar = (array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes[$size] : null;

        $link = '';

        if ($avatar === null or !$this->$avatar) {
            if ($returnDefault) {
                $link = \JUri::root() . 'media/com_socialcommunity/images/no_profile_200x200.png';
            }
        } else {
            $link = $this->mediaUrl . '/user' .$this->user_id. '/' . $this->$avatar;
        }

        return $link;
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $keys = array(
     *     'user_id' => $userId
     * );
     *
     * $profile = new Prism\Integration\Profile\Socialcommunity(\JFactory::getDbo());
     * $profile->load($keys);
     *
     * $location = $profile->getLocation();
     * </code>
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Return a country code of a country where the user lives.
     *
     * <code>
     * $keys = array(
     *     'user_id' => $userId
     * );
     *
     * $profile = new Prism\Integration\Profile\Socialcommunity(\JFactory::getDbo());
     * $profile->load($keys);
     *
     * $countryCode = $profile->getCountryCode();
     * </code>
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }

    /**
     * Set the URL to the media folder.
     *
     * <code>
     * $keys = array(
     *     'user_id' => $userId
     * );
     *
     * $url = "/media/socialcommunity/user101;
     *
     * $profile = new Prism\Integration\Profile\Socialcommunity(\JFactory::getDbo());
     * $profile->load($keys);
     *
     * $profile->setMediaUrl($url);
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
     * $profiles = new Prism\Integration\Profile\Socialcommunity(\JFactory::getDbo());
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
