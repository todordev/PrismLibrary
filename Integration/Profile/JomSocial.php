<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profile
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profile;

defined('JPATH_PLATFORM') or die;

\JLoader::register('CRoute', JPATH_ROOT . '/components/com_community/libraries/core.php');

/**
 * This class provides functionality to
 * integrate extensions with the profile of JomSocial.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class JomSocial implements ProfileInterface
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
    protected $avatarSizes = array(
        'icon' => 'thumb',
        'small' => 'thumb',
        'medium' => 'avatar',
        'large' => 'avatar',
    );

    /**
     * Database driver.
     * 
     * @var \JDatabaseDriver
     */
    protected $db;

    protected static $instances = array();

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
        $this->db = $db;
    }

    /**
     * Create an object.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = Prism\Integration\Profile\JomSocial::getInstance(\JFactory::getDbo(), $userId);
     * </code>
     *
     * @param  \JDatabaseDriver $db
     * @param  int $id
     *
     * @return null|JomSocial
     */
    public static function getInstance(\JDatabaseDriver $db, $id)
    {
        if (empty(self::$instances[$id])) {
            $item                 = new JomSocial($db);
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
     * $profile = new Prism\Integration\Profile\JomSocial(\JFactory::getDbo());
     * $profile->load($userId);
     * </code>
     *
     * @param int $id
     */
    public function load($id)
    {
        $query = $this->db->getQuery(true);
        $query
            ->select('a.userid AS user_id, a.avatar, a.thumb')
            ->from($this->db->quoteName('#__community_users', 'a'))
            ->where('a.userid = ' . (int)$id);

        $this->db->setQuery($query);
        $result = $this->db->loadAssoc();

        if (!empty($result)) { // Set values to variables
            $this->bind($result);
        }
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
     * $profile = new Prism\Integration\Profile\JomSocial(\JFactory::getDbo());
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
        $avatar = (array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes[$size] : null;

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

        return $this->location;
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
