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

/**
 * This class provides functionality to
 * integrate extensions with the profile of Kunena.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class Kunena implements ProfileInterface
{
    protected $user_id;
    protected $avatar;
    protected $name;
    protected $username;
    protected $permalink;
    protected $alias;
    protected $location;
    protected $country_code;

    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array(
        'icon' => array('folder' => 'size36', 'noimage' => 's_nophoto.jpg'),
        'small' => array('folder' => 'size72', 'noimage' => 's_nophoto.jpg'),
        'medium' => array('folder' => 'size72', 'noimage' => 'nophoto.jpg'),
        'large' => array('folder' => 'size200', 'noimage' => 'nophoto.jpg'),
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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
     * </code>
     * 
     * @param \JDatabaseDriver $db
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
     * $profile = Prism\Integration\Profile\Kunena::getInstance(\JFactory::getDbo(), $userId);
     * </code>
     *
     * @param  \JDatabaseDriver $db
     * @param  int $id
     *
     * @return null|Kunena
     */
    public static function getInstance(\JDatabaseDriver $db, $id)
    {
        if (!array_key_exists($id, self::$instances)) {
            $item                 = new Kunena($db);
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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
     * $profile->load($userId);
     * </code>
     *
     * @param int $id
     */
    public function load($id)
    {
        $query = $this->db->getQuery(true);
        $query
            ->select('a.userid AS user_id, a.avatar, a.location')
            ->from($this->db->quoteName('#__kunena_users', 'a'))
            ->where('a.userid = ' . (int)$id);

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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
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
            $link = 'index.php?option=com_kunena&view=profile&userid=' . (int)$this->user_id;

            if ($route) {
                $link = \KunenaRoute::_($link, false);
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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $avatar = $profile->getAvatar();
     * </code>
     *
     * @param string $size One of the following sizes - icon, small, medium, large.
     * @param bool   $returnDefault Return or not a link to default avatar.
     * 
     * @return string Return a link to the picture.
     */
    public function getAvatar($size = 'small', $returnDefault = true)
    {
        $link = '';

        // Get avatar size.
        if (\JString::strlen($this->avatar) > 0) {
            $folder = (!array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes['small']['folder'] : $this->avatarSizes[$size]['folder'];
            $link = \JUri::root() . 'media/kunena/avatars/resized/' . $folder . '/'. $this->avatar;
        } else {
            if ($returnDefault) {
                $noImage = (!array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes['small']['noimage'] : $this->avatarSizes[$size]['noimage'];
                $link    = \JUri::root() . 'media/kunena/avatars/' . $noImage;
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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
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
