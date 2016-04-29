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
 * integrate extensions with the profile of Kunena.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class Kunena extends TableImmutable implements ProfileInterface
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
     * $profile = new Prism\Integration\Profile\Kunena(\JFactory::getDbo());
     * </code>
     *
     * @param \JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db)
    {
        parent::__construct($db);

        $this->avatarSizes = array(
            'icon' => array('folder' => 'size36', 'noimage' => 's_nophoto.jpg'),
            'small' => array('folder' => 'size72', 'noimage' => 's_nophoto.jpg'),
            'medium' => array('folder' => 'size72', 'noimage' => 'nophoto.jpg'),
            'large' => array('folder' => 'size200', 'noimage' => 'nophoto.jpg'),
        );
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
     * @param array $keys
     * @param array $options
     */
    public function load($keys, array $options = array())
    {
        $query = $this->db->getQuery(true);
        $query
            ->select('a.userid AS user_id, a.avatar, a.location')
            ->from($this->db->quoteName('#__kunena_users', 'a'))
            ->where('a.userid = ' . (int)$keys);

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
