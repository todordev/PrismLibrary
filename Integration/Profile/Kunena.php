<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profile
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\Integration\Profile;

defined('JPATH_PLATFORM') or die;

\JLoader::register("Prism\\Integration\\Profile\\ProfileInterface", JPATH_LIBRARIES . '/prism/integration/profile/profileinterface.php');

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
        "icon" => array("folder" => "size36", "noimage" => "s_nophoto.jpg"),
        "small" => array("folder" => "size72", "noimage" => "s_nophoto.jpg"),
        "medium" => array("folder" => "size72", "noimage" => "nophoto.jpg"),
        "large" => array("folder" => "size200", "noimage" => "nophoto.jpg"),
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
        if (empty(self::$instances[$id])) {
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
            ->select("a.userid AS user_id, a.avatar, a.location")
            ->from($this->db->quoteName("#__kunena_users", "a"))
            ->where("a.userid = " . (int)$id);

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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
     * $profile->bind($data);
     * </code>
     *
     * @param array $data
     * @param array $ignored
     */
    public function bind($data, $ignored = array())
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $ignored)) {
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
     * @return string Return a link to the profile.
     */
    public function getLink()
    {
        return \KunenaRoute::_("index.php?option=com_kunena&view=profile&userid=" . $this->user_id, false);
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
    public function getAvatar($size = "small", $returnDefault = true)
    {
        $link = "";

        // Get avatar size.
        if (!empty($this->avatar)) {
            $folder = (!array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes["small"]["folder"] : $this->avatarSizes[$size]["folder"];
            $link = \JUri::root() . "media/kunena/avatars/resized/" . $folder . "/". $this->avatar;
        } else {
            if ($returnDefault) {
                $noimage = (!array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes["small"]["noimage"] : $this->avatarSizes[$size]["noimage"];
                $link    = \JUri::root() . "media/kunena/avatars/" . $noimage;
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
        return "";
    }
}
