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

/**
 * This class provides functionality to
 * integrate extensions with the profile of Gravatar.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class Gravatar extends TableImmutable implements ProfileInterface
{
    protected $user_id;
    protected $hash;
    protected $email;

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
     * $profile = new Prism\Integration\Profile\Gravatar(\JFactory::getDbo());
     * </code>
     *
     * @param  \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        parent::__construct($db);

        $this->avatarSizes = array(
            'icon' => '40',
            'small' => '80',
            'medium' => '160',
            'large' => '200',
        );
    }

    /**
     * Load user data
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\Gravatar(\JFactory::getDbo());
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
            ->select('a.id AS user_id, a.email, MD5(a.email) as hash')
            ->from($this->db->quoteName('#__users', 'a'))
            ->where('a.id = ' . (int)$keys);

        $this->db->setQuery($query);
        $result = (array)$this->db->loadAssoc();

        $this->bind($result);
    }

    /**
     * Provide a link to social profile.
     * This method integrates users with profiles
     * of some Joomla! social extensions.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\Gravatar(\JFactory::getDbo());
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
        return 'javascript:void(0)';
    }

    /**
     * Provide a link to social avatar.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\Gravatar(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $avatar = $profile->getAvatar();
     * </code>
     *
     * @param string $size  One of the following sizes - icon, small, medium, large.
     * @param bool $returnDefault
     *
     * @return string Return a link to the picture.
     */
    public function getAvatar($size = 'small', $returnDefault = true)
    {
        $avatarSize = (!array_key_exists($size, $this->avatarSizes)) ? null : (int)$this->avatarSizes[$size];

        $link = 'http://www.gravatar.com/avatar/' . $this->hash;

        if ($avatarSize !== null) {
            $link .= '?s=' . $avatarSize;
        }

        return $link;
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Integration\Profile\Gravatar(\JFactory::getDbo());
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
     * $profile = new Prism\Integration\Profile\Gravatar(\JFactory::getDbo());
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
