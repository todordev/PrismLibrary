<?php
/**
 * @package      ITPrism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\Integration\Profiles;

use Joomla\String\String;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality used for integrating
 * extensions with the profile of Easy Profile.
 *
 * @package      ITPrism
 * @subpackage   Integrations\Profiles
 */
class EasyProfile implements ProfilesInterface
{
    protected $profiles = array();

    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array(
        "icon"   => "mini_",
        "small"  => "mini_",
        "medium" => "_",
        "large"  => "_",
    );

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
     * $profiles = new Prism\Integration\Profiles\EasyProfile(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Load data about profiles from database.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Integration\Profiles\EasyProfile(\JFactory::getDbo());
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
                    "a.id AS user_id, a.avatar, ".
                    $query->concatenate(array("b.id", "b.username"), ":") . " AS slug"
                )
                ->from($this->db->quoteName("#__jsn_users", "a"))
                ->innerJoin($this->db->quoteName("#__users", "b") . " ON a.id = b.id")
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
     * $profiles = new Prism\Integration\Profiles\EasyProfile(\JFactory::getDbo());
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
            $link = \JUri::root() . "components/com_jsn/assets/img/default.jpg";
        } else {
            $avatar = (!isset($this->avatarSizes[$size])) ? null : $this->avatarSizes[$size];

            if (!empty($this->profiles[$userId]->avatar)) {

                if (!empty($avatar)) {
                    $file = String::trim($this->profiles[$userId]->avatar);
                    $fileSplit = explode("_", $file);
                    $link = \JUri::root() . $fileSplit[0]  . $avatar . $fileSplit[1];
                } else {
                    $link = \JUri::root() . String::trim($this->profiles[$userId]->avatar);
                }

            } else {
                if ($returnDefault) {
                    $link = \JUri::root() . "components/com_jsn/assets/img/default.jpg";
                }
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
     * $profiles = new Prism\Integration\Profiles\EasyProfile(\JFactory::getDbo());
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
        $link = "";
        
        if (isset($this->profiles[$userId])) {
            $link = \JRoute::_('index.php?option=com_jsn&view=profile&id='.$this->profiles[$userId]->slug);
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
     * $profiles = new Prism\Integration\Profiles\EasyProfile(\JFactory::getDbo());
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
        return "";
    }

    /**
     * Return a country code of a country where the user lives.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\EasyProfile(\JFactory::getDbo());
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
        return "";
    }
}
