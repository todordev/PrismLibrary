<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\Integration\Profiles;

use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

defined('JPATH_PLATFORM') or die;

jimport("SocialCommunity.init");

/**
 * This class provides functionality used for integrating
 * extensions with the profile of SocialCommunity.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
class SocialCommunity implements ProfilesInterface
{
    protected $profiles = array();

    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array(
        "icon" => array("default" => "no_profile_24x24.png", "image" => "image_icon"),
        "small" => array("default" => "no_profile_50x50.png", "image" => "image_square"),
        "medium" => array("default" => "no_profile_100x100.png", "image" => "image_small"),
        "large" => array("default" => "no_profile_200x200.png", "image" => "image")
    );

    protected $path;

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
     * $profiles = new Prism\Integration\Profiles\SocialCommunity(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;

        // Set path to pictures
        $params = \JComponentHelper::getParams("com_socialcommunity");
        /** @var  $params Registry */

        $path   = $params->get("images_directory", "/images/profiles");

        $this->setPath($path);
    }

    /**
     * Load data about profiles from database.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Integration\Profiles\SocialCommunity(\JFactory::getDbo());
     * $profiles->load($ids);
     * </code>
     *
     * @param array $ids
     */
    public function load(array $ids)
    {
        if (!empty($ids)) {

            // Create a new query object.
            $query = $this->db->getQuery(true);
            $query
                ->select(
                    "a.id AS user_id, a.image_icon, a.image_small, a.image_square, a.image, " .
                    $query->concatenate(array("a.id", "a.alias"), ":") . " AS slug, " .
                    "b.name as location, b.country_code"
                )
                ->from($this->db->quoteName("#__itpsc_profiles", "a"))
                ->leftJoin($this->db->quoteName("#__itpsc_locations", "b") . " ON a.location_id = b.id")
                ->where("a.id IN ( " . implode(",", $ids) . ")");

            $this->db->setQuery($query);
            $this->profiles = (array)$this->db->loadObjectList("user_id");
        }
    }

    /**
     * Get a link to user avatar.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\SocialCommunity(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $avatar = $profiles->getAvatar($userId);
     * </code>
     * 
     * @param integer $userId
     * @param string   $size One of the following sizes - icon, small, medium, large.
     * @param bool   $returnDefault Return or not a link to default avatar.
     *
     * @return string
     */
    public function getAvatar($userId, $size = "small", $returnDefault = true)
    {
        $link = "";
        if (!isset($this->profiles[$userId])) {
            $link   = \JUri::root() . "media/com_socialcommunity/images/" . $this->avatarSizes["square"]["default"];
        } else {
            // Get avatar size.
            $avatar = (isset($this->avatarSizes[$size])) ? $this->avatarSizes[$size]["image"] : null;

            if (!$avatar or empty($this->profiles[$userId]->$avatar)) {
                if ($returnDefault) {
                    $avatar = (isset($this->avatarSizes[$size])) ? $this->avatarSizes[$size]["default"] : $this->avatarSizes["square"]["default"];
                    $link   = \JUri::root() . "media/com_socialcommunity/images/" . $avatar;
                }
            } else {
                $link = \JUri::root() . ltrim($this->path . "/" . $this->profiles[$userId]->$avatar, "/");
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
     * $profiles = new Prism\Integration\Profiles\SocialCommunity(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $link = $profiles->getLink($userId);
     * </code>
     * 
     * @param integer $userId
     *
     * @return string
     */
    public function getLink($userId)
    {
        if (!isset($this->profiles[$userId])) {
            $link = "";
        } else {
            $link = \SocialCommunityHelperRoute::getProfileRoute($this->profiles[$userId]->slug);
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
     * $profiles = new Prism\Integration\Profiles\SocialCommunity(\JFactory::getDbo());
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
        if (!isset($this->profiles[$userId])) {
            return null;
        } else {
            return $this->profiles[$userId]->location;
        }
    }

    /**
     * Return a country code of a country where the user lives.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\SocialCommunity(\JFactory::getDbo());
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
        if (!isset($this->profiles[$userId])) {
            return null;
        } else {
            return $this->profiles[$userId]->country_code;
        }
    }

    /**
     * Set the path to the images folder.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $path = "/images/profiles;
     *
     * $profiles = new Prism\Integration\Profiles\SocialCommunity(\JFactory::getDbo());
     * $profiles->setPath($path);
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
