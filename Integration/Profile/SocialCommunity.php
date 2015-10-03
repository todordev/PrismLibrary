<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profile
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profile;

use Joomla\Registry\Registry;

defined('JPATH_PLATFORM') or die;

jimport('SocialCommunity.init');

/**
 * This class provides functionality to
 * integrate extensions with the profile of Social Community.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class SocialCommunity implements ProfileInterface
{
    protected $user_id;
    protected $image_icon;
    protected $image_small;
    protected $image_square;
    protected $image;
    protected $location;
    protected $country_code;
    protected $slug;
    protected $path;

    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array(
        'icon' => 'image_icon',
        'small' => 'image_square',
        'medium' => 'image_small',
        'large' => 'image',
    );

    /**
     * Database driver.
     *
     * @var \JDatabaseDriver
     */
    protected $db;

    protected static $instances = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\SocialCommunity(\JFactory::getDbo());
     * </code>
     * 
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;

        // Set path to pictures
        $params = \JComponentHelper::getParams('com_socialcommunity');
        /** @var  $params Registry */

        $path   = $params->get('images_directory', '/images/profiles');

        $this->setPath($path);
    }

    /**
     * Create an object
     *
     * <code>
     * $userId = 1;
     *
     * $profile = Prism\Integration\Profile\SocialCommunity::getInstance(\JFactory::getDbo(), $userId);
     * </code>
     *
     * @param  \JDatabaseDriver $db
     * @param  int $id
     *
     * @return SocialCommunity|null
     */
    public static function getInstance(\JDatabaseDriver $db, $id)
    {
        if (!array_key_exists($id, self::$instances)) {
            $item   = new SocialCommunity($db);
            $item->load($id);

            self::$instances[$id] = $item;
        }

        return self::$instances[$id];
    }

    /**
     * Load user data
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\SocialCommunity(\JFactory::getDbo());
     * $profile->load($userId);
     * </code>
     * 
     * @param int $id User ID.
     */
    public function load($id)
    {
        $query = $this->db->getQuery(true);
        $query
            ->select(
                'a.id AS user_id, a.image_icon, a.image_small, a.image_square, a.image, ' .
                $query->concatenate(array('a.id', 'a.alias'), ':') . ' AS slug, ' .
                'b.name as location, b.country_code'
            )
            ->from($this->db->quoteName('#__itpsc_profiles', 'a'))
            ->leftJoin($this->db->quoteName('#__itpsc_locations', 'b') . ' ON a.location_id = b.id')
            ->where('a.id = ' . (int)$id);

        $this->db->setQuery($query);
        $result = (array)$this->db->loadAssoc();

        $this->bind($result);
    }

    /**
     * Set values to object properties.
     *
     * <code>
     * $data = array(
     *     "name" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $profile = new Prism\Integration\Profile\SocialCommunity(\JFactory::getDbo());
     * $profile->bind($data);
     * </code>
     *
     * @param array $data
     * @param array $ignored
     */
    public function bind($data, array $ignored = array())
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $ignored, true)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Provide a link to social profile.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\SocialCommunity(\JFactory::getDbo());
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
        if (\JString::strlen($this->slug) > 0) {
            $link = \SocialCommunityHelperRoute::getProfileRoute($this->slug);

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
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\SocialCommunity(\JFactory::getDbo());
     * $profile->load($userId);
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

        if ($avatar === null or \JString::strlen($this->$avatar) === 0) {
            if ($returnDefault) {
                $link = \JUri::root() . 'media/com_socialcommunity/images/no_profile_200x200.png';
            }
        } else {
            $link = \JUri::root() . ltrim($this->path . '/' . $this->$avatar, '/');
        }

        return $link;
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\SocialCommunity(\JFactory::getDbo());
     * $profile->load($userId);
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
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\SocialCommunity(\JFactory::getDbo());
     * $profile->load($userId);
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
     * Set the path to the images folder.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $path = "/images/profiles;
     *
     * $profile = new Prism\Integration\Profile\SocialCommunity(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $profile->setPath($path);
     * </code>
     *
     * @param string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}
