<?php
/**
 * @package      ITPrism
 * @subpackage   Integrations\Profile
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profile;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with the profile of Social Community.
 *
 * @package      ITPrism
 * @subpackage   Integrations\Profile
 */
class EasyProfile implements ProfileInterface
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
    protected $avatarSizes = array(
        'icon'   => 'mini_',
        'small'  => 'mini_',
        'medium' => '_',
        'large'  => '_',
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
     * $profile = new Prism\Integration\Profile\EasyProfile(\JFactory::getDbo());
     * </code>
     * 
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Create an object
     *
     * <code>
     * $userId = 1;
     *
     * $profile = Prism\Integration\Profile\EasyProfile::getInstance(\JFactory::getDbo(), $userId);
     * </code>
     * 
     * @param  \JDatabaseDriver $db
     * @param  int $id
     *
     * @return self|null
     */
    public static function getInstance(\JDatabaseDriver $db, $id)
    {
        if (!array_key_exists($id, self::$instances)) {
            $item   = new EasyProfile($db);
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
     * $profile = new Prism\Integration\Profile\EasyProfile(\JFactory::getDbo());
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
                'a.id AS user_id, a.avatar, '.
                $query->concatenate(array('b.id', 'b.username'), ':') . ' AS slug'
            )
            ->from($this->db->quoteName('#__jsn_users', 'a'))
            ->innerJoin($this->db->quoteName('#__users', 'b') . ' ON a.id = b.id')
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
     *     "location" => "...",
     *     "country_code" => "...",
     * ...
     * );
     *
     * $profile = new Prism\Integration\Profile\EasyProfile(\JFactory::getDbo());
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
     * $profile = new Prism\Integration\Profile\EasyProfile(\JFactory::getDbo());
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
        if ($this->slug !== null) {
            $link = \JRoute::_('index.php?option=com_jsn&view=profile&id='.$this->slug);
        }

        return $link;
    }

    /**
     * Provide a link to social avatar.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\EasyProfile(\JFactory::getDbo());
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
        $avatar = (!array_key_exists($size, $this->avatarSizes)) ? null : $this->avatarSizes[$size];

        $link = '';

        if ($this->avatar !== null) {
            $file = \JString::trim($this->avatar);
            $fileSplit = explode('_', $file);
            $link = \JUri::root() . $fileSplit[0]  . $avatar . $fileSplit[1];
        } else {
            if ($returnDefault) {
                $link = \JUri::root() . 'components/com_jsn/assets/img/default.jpg';
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
     * $profile = new Prism\Integration\Profile\EasyProfile(\JFactory::getDbo());
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
     * $profile = new Prism\Integration\Profile\EasyProfile(\JFactory::getDbo());
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
