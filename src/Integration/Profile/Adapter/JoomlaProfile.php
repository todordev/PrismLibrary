<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profile
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Profile\Adapter;

use Prism\Library\Prism\Database\TableImmutable;
use Prism\Library\Prism\Integration\Profile\ProfileMapper;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with the profile of Joomla Profile.
 *
 * @package      Prism
 * @subpackage   Integrations\Profile
 */
class JoomlaProfile extends TableImmutable implements ProfileMapper
{
    protected $user_id;
    protected $name;
    protected $email;
    protected $username;
    protected $aboutme;
    protected $address1;
    protected $address2;
    protected $city;
    protected $country;
    protected $postal_code;
    protected $website;

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
     * $profile = new Prism\Library\Prism\Integration\Profile\JoomlaProfile(\JFactory::getDbo());
     * </code>
     *
     * @param null|\JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db = null)
    {
        parent::__construct($db);

        $this->avatarSizes = array(
            'icon'   => '',
            'small'  => '',
            'medium' => '',
            'large'  => '',
        );
    }

    /**
     * Load user data
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Library\Prism\Integration\Profile\JoomlaProfile(\JFactory::getDbo());
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
            ->select('a.id AS user_id, a.name, a.email, a.username')
            ->from($this->db->quoteName('#__users', 'a'));

        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $query->where($this->db->quoteName('a.'.$key) .' = ' . $this->db->quote($value));
            }
        } else {
            $query->where('a.id = ' . (int)$keys);
        }

        $this->db->setQuery($query);
        $result = (array)$this->db->loadAssoc();

        if (count($result) > 0) {
            $this->bind($result);

            $subQuery = $this->db->getQuery(true);
            $subQuery
                ->select('b.profile_key, b.profile_value')
                ->from($this->db->quoteName('#__user_profiles', 'b'))
                ->where('b.user_id = '. (int)$result['user_id']);

            $this->db->setQuery($subQuery);
            $results = (array)$this->db->loadAssocList();

            foreach ($results as $result) {
                list($p, $property) = explode('.', $result['profile_key']);
                $this->$property = str_replace('"', '', $result['profile_value']);
            }
        }
    }

    /**
     * Return an array that determine object properties.
     *
     * <code>
     * $userId = 1;
     *
     * $profile = new Prism\Library\Prism\Integration\Profile\JoomlaProfile(\JFactory::getDbo());
     * $profile->load($userId);
     *
     * $mapping = $profile->getMapping();
     * </code>
     *
     * @return string
     */
    public function getMapping()
    {
        return array (
            'user_id'   => 'user_id',
            'name'      => 'name',
            'username'  => 'username',
            'email'     => 'email',
            'address'   => 'address1',
            'city'      => 'city',
            'country'   => 'country',
            'location'  => 'city',
            'post_code' => 'postal_code',
            'website'   => 'website',
            'bio'       => 'aboutme'
        );
    }

    /**
     * Call an object method if exits.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_id'  => 1
     * ));
     *
     * $factory = new Prism\Library\Prism\Integration\Profile\Factory($options, JFactory::getDbo());
     *
     * $profileAdapter = $factory->create();
     *
     * $avatar = $profileAdapter->getAvatar('small');
     * $link   = $profileAdapter->getLink();
     * </code>
     *
     * @param   string $name
     * @param   array  $arguments
     *
     * @return  mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array(array($this, $name), $arguments);
        }

        return null;
    }
}
