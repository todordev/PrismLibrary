<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profiles;

defined('JPATH_PLATFORM') or die;

\JLoader::register('Foundry', JPATH_ROOT . '/administrator/components/com_easysocial/includes/foundry.php');

/**
 * This class provides functionality used for integrating
 * extensions with the profile of EasySocial.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
class EasySocial implements ProfilesInterface
{
    protected $profiles = array();

    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array();

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
     * $profiles = new Prism\Integration\Profiles\EasySocial(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;

        $this->avatarSizes = array(
            'icon' => 'small',
            'small' => 'medium',
            'medium' => 'square',
            'large' => 'large',
        );
    }

    /**
     * Load data about profiles from database.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Integration\Profiles\EasySocial(\JFactory::getDbo());
     * $profiles->load($ids);
     * </code>
     *
     * @param array $userIds
     */
    public function load(array $userIds)
    {
        if (count($userIds) > 0) {
            $query = $this->db->getQuery(true);
            $query
                ->select(
                    'a.id AS user_id, a.name, a.username, ' .
                    'b.alias, b.permalink, ' .
                    'c.small, c.medium, c.square, c.large'
                )
                ->from($this->db->quoteName('#__users', 'a'))
                ->leftJoin($this->db->quoteName('#__social_users', 'b') . ' ON a.id = b.user_id')
                ->leftJoin($this->db->quoteName('#__social_avatars', 'c') . ' ON a.id = c.uid')
                ->where('a.id IN ( ' . implode(',', $userIds) . ')');

            $this->db->setQuery($query);
            $this->profiles = (array)$this->db->loadObjectList('user_id');
        }
    }

    /**
     * Get a link to user avatar.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\EasySocial(\JFactory::getDbo());
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
    public function getAvatar($userId, $size = 'small', $returnDefault = true)
    {
        $link = '';
        if (!array_key_exists($userId, $this->profiles)) {
            $link = \JUri::root() . 'media/com_easysocial/defaults/avatars/user/'.$this->avatarSizes['small'].'.png';
        } else {
            $avatar = (!array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes['small'] : $this->avatarSizes[$size];

            if (!empty($this->profiles[$userId]->$avatar)) {
                $link = \JUri::root() . 'media/com_easysocial/avatars/users/' . (int)$this->profiles[$userId]->user_id . '/' . $this->profiles[$userId]->$avatar;
            } else {
                if ($returnDefault) {
                    $link = \JUri::root() . 'media/com_easysocial/defaults/avatars/user/' . $avatar . '.png';
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
     * $profiles = new Prism\Integration\Profiles\EasySocial(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $link = $profiles->getLink($userId);
     * </code>
     *
     * @param int $userId
     * @param bool $route Route or not the link.
     *
     * @return string
     */
    public function getLink($userId, $route = true)
    {
        $link = '';
        if (array_key_exists($userId, $this->profiles) and $route) {
            $options = array('id' => $this->getAlias($this->profiles[$userId]));
            $link = \FRoute::profile($options);
        }

        return $link;
    }

    protected function getAlias($user)
    {
        $config = \Foundry::config();

        // Default permalink to use.
        $name = $config->get('users.aliasName') === 'realname' ? $user->name : $user->username;
        $name = $user->user_id . ':' . $name;

        // Check if the permalink is set
        if (\JString::strlen($user->permalink) > 0) {
            $name = $user->permalink;
        }

        // If alias exists and permalink doesn't we use the alias
        if (\JString::strlen($user->alias) > 0 and !$user->permalink) {
            $name = $user->alias;
        }

        // Ensure that the name is a safe url.
        $name = \JFilterOutput::stringURLSafe($name);

        return $name;
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\EasySocial(\JFactory::getDbo());
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
        return '';
    }

    /**
     * Return a country code of a country where the user lives.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Integration\Profiles\EasySocial(\JFactory::getDbo());
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
        return '';
    }
}
