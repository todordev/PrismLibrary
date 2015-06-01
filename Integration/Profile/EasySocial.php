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
\JLoader::register("Foundry", JPATH_ROOT . '/administrator/components/com_easysocial/includes/foundry.php');

/**
 * This class provides functionality to
 * integrate extensions with the profile of JomSocial.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class EasySocial implements ProfileInterface
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
        "icon" => "small",
        "small" => "medium",
        "medium" => "square",
        "large" => "large",
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
     * $profile = new Prism\Integration\Profile\EasySocial(\JFactory::getDbo());
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
     * $profile = Prism\Integration\Profile\EasySocial::getInstance(\JFactory::getDbo(), $userId);
     * </code>
     *
     * @param  \JDatabaseDriver $db
     * @param  int $id
     *
     * @return null|EasySocial
     */
    public static function getInstance(\JDatabaseDriver $db, $id)
    {
        if (empty(self::$instances[$id])) {
            $item                 = new EasySocial($db);
            $item->load($id);

            self::$instances[$id] = $item;
        }

        return self::$instances[$id];
    }

    /**
     * Load user data from database.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\EasySocial(\JFactory::getDbo());
     * $profile->load($userId);
     * </code>
     *
     * @param int $id
     */
    public function load($id)
    {
        $query = $this->db->getQuery(true);
        $query
            ->select(
                "a.id AS user_id, a.name, a.username, ".
                "b.alias, b.permalink, " .
                "c.small, c.medium, c.square, c.large"
            )
            ->from($this->db->quoteName("#__users", "a"))
            ->leftJoin($this->db->quoteName("#__social_users", "b") . " ON a.id = b.user_id")
            ->leftJoin($this->db->quoteName("#__social_avatars", "c") . " ON a.id = c.uid")
            ->where("a.id =" . (int)$id);

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
     * $profile = new Prism\Integration\Profile\EasySocial(\JFactory::getDbo());
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
     * $profile = new Prism\Integration\Profile\EasySocial(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $link = $profile->getLink();
     * </code>
     *
     * @return string Return a link to the profile.
     */
    public function getLink()
    {
        $options = array('id' => $this->getAlias());

        return \FRoute::profile($options);
    }

    /**
     * Provide a link to social avatar.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\EasySocial(\JFactory::getDbo());
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
    public function getAvatar($size = "small", $returnDefault = true)
    {
        $avatar = (!isset($this->avatarSizes[$size])) ? $this->avatarSizes["small"] : $this->avatarSizes[$size];

        $link = "";

        if (!empty($this->$avatar)) {
            $link = \JUri::root() . "media/com_easysocial/avatars/users/" . (int)$this->user_id . "/" . $this->$avatar;
        } else {
            if ($returnDefault) {
                $link = \JUri::root() . "media/com_easysocial/defaults/avatars/users/" . $avatar . ".png";
            }
        }

        return $link;
    }

    protected function getAlias()
    {
        $config = \Foundry::config();

        // Default permalink to use.
        $name = $config->get('users.aliasName') == 'realname' ? $this->name : $this->username;
        $name = $this->user_id . ':' . $name;

        // Check if the permalink is set
        if ($this->permalink && !empty($this->permalink)) {
            $name = $this->permalink;
        }

        // If alias exists and permalink doesn't we use the alias
        if ($this->alias && !empty($this->alias) && !$this->permalink) {
            $name = $this->alias;
        }

        // Ensure that the name is a safe url.
        $name = \JFilterOutput::stringURLSafe($name);

        return $name;
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\EasySocial(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $location = $profile->getLocation();
     * </code>
     *
     * @return string
     */
    public function getLocation()
    {
        if (is_null($this->location)) {
            $this->prepareLocation();
        }

        return $this->location;
    }

    /**
     * Return a country code of a country where the user lives.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\EasySocial(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $countryCode = $profile->getCountryCode();
     * </code>
     *
     * @return string
     */
    public function getCountryCode()
    {
        if (is_null($this->country_code)) {
            $this->prepareLocation();
        }

        return $this->country_code;
    }

    private function prepareLocation()
    {
        $result = array();

        $query = $this->db->getQuery(true);

        $query
            ->select("a.id")
            ->from($this->db->quoteName("#__social_fields", "a"))
            ->where("a.unique_key =  " . $this->db->quote("ADDRESS"));

        $this->db->setQuery($query);
        $typeId = $this->db->loadResult();

        if (!empty($typeId)) {

            $query = $this->db->getQuery(true);

            $query
                ->select("a.data")
                ->from($this->db->quoteName("#__social_fields_data", "a"))
                ->where("a.uid =  " . (int)$this->user_id)
                ->where("a.field_id =  " . (int)$typeId);

            $this->db->setQuery($query);
            $result = $this->db->loadResult();

            if (!empty($result)) { // Set values to variables
                $result = json_decode($result, true);
            } else {
                $result = array();
            }
        }

        $this->location = (isset($result["city"])) ? $result["city"] : "";
        $this->country_code = (isset($result["country"])) ? $result["country"] : "";
    }
}
