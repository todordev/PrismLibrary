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

\JLoader::register('Foundry', JPATH_ROOT . '/administrator/components/com_easysocial/includes/foundry.php');

/**
 * This class provides functionality to
 * integrate extensions with the profile of Easy Social.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class EasySocial extends TableImmutable implements ProfileInterface
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
    protected $avatarSizes = array();

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
        parent::__construct($db);

        $this->avatarSizes = array(
            'icon' => 'small',
            'small' => 'medium',
            'medium' => 'square',
            'large' => 'large',
        );
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
     * @param array $keys
     * @param array $options
     *
     * @throws \RuntimeException
     */
    public function load($keys, array $options = array())
    {
        $query = $this->db->getQuery(true);
        $query
            ->select(
                'a.id AS user_id, a.name, a.username, '.
                'b.alias, b.permalink, ' .
                'c.small, c.medium, c.square, c.large'
            )
            ->from($this->db->quoteName('#__users', 'a'))
            ->leftJoin($this->db->quoteName('#__social_users', 'b') . ' ON a.id = b.user_id')
            ->leftJoin($this->db->quoteName('#__social_avatars', 'c') . ' ON a.id = c.uid')
            ->where('a.id =' . (int)$keys);

        $this->db->setQuery($query);
        $result = (array)$this->db->loadAssoc();

        $this->bind($result);
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
     * @param bool $route Route or not the link.
     *
     * @return string Return a link to the profile.
     */
    public function getLink($route = true)
    {
        $link = '';

        if ($route) {
            $options = array('id' => $this->getAlias());
            $link = \FRoute::profile($options);
        }

        return $link;
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
    public function getAvatar($size = 'small', $returnDefault = true)
    {
        $avatar = (!array_key_exists($size, $this->avatarSizes)) ? $this->avatarSizes['small'] : $this->avatarSizes[$size];

        $link = '';

        if ($this->$avatar !== null) {
            $link = \JUri::root() . 'media/com_easysocial/avatars/users/' . (int)$this->user_id . '/' . $this->$avatar;
        } else {
            if ($returnDefault) {
                $link = \JUri::root() . 'media/com_easysocial/defaults/avatars/users/' . $avatar . '.png';
            }
        }

        return $link;
    }

    protected function getAlias()
    {
        $config = \Foundry::config();

        // Default permalink to use.
        $name = $config->get('users.aliasName') === 'realname' ? $this->name : $this->username;
        $name = $this->user_id . ':' . $name;

        // Check if the permalink is set
        if ($this->permalink !== '') {
            $name = $this->permalink;
        }

        // If alias exists and permalink doesn't we use the alias
        if ($this->alias !== '' and !$this->permalink) {
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
        if ($this->location !== null) {
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
        if ($this->country_code !== null) {
            $this->prepareLocation();
        }

        return $this->country_code;
    }

    private function prepareLocation()
    {
        $result = array();

        $query = $this->db->getQuery(true);

        $query
            ->select('a.id')
            ->from($this->db->quoteName('#__social_fields', 'a'))
            ->where('a.unique_key =  ' . $this->db->quote('ADDRESS'));

        $this->db->setQuery($query);
        $typeId = (int)$this->db->loadResult();

        if ($typeId > 0) {
            $query = $this->db->getQuery(true);

            $query
                ->select('a.data')
                ->from($this->db->quoteName('#__social_fields_data', 'a'))
                ->where('a.uid =  ' . (int)$this->user_id)
                ->where('a.field_id =  ' . (int)$typeId);

            $this->db->setQuery($query);
            $result = (string)$this->db->loadResult();

            if ($result !== '') {
                $result = json_decode($result, true);
            } else {
                $result = array();
            }
        }

        $this->location = (array_key_exists('city', $result)) ? $result['city'] : '';
        $this->country_code = (array_key_exists('country', $result)) ? $result['country'] : '';
    }
}
