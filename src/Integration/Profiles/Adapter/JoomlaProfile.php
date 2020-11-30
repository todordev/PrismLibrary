<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Integration\Profiles\Adapter;

use Prism\Library\Database;
use Prism\Library\Integration\Profile\Adapter\JoomlaProfile as JProfile;
use Prism\Library\Integration\Profile\Profile;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality used for integrating
 * extensions with the profile of Joomla Profile.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
class JoomlaProfile extends Database\Collection
{
    /**
     * Predefined image sizes.
     *
     * @var array
     */
    protected $avatarSizes = array();

    /**
     * Initialize the object.
     *
     * @param null|\JDatabaseDriver $db
     */
    public function __construct(\JDatabaseDriver $db = null)
    {
        parent::__construct($db);

        $this->avatarSizes = array(
            'icon' => '',
            'small' => '',
            'medium' => '',
            'large' => ''
        );
    }

    /**
     * Load data about profiles from database.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     *
     * $profiles = new Prism\Library\Integration\Profiles\JoomlaProfile(\JFactory::getDbo());
     * $profiles->load(array('ids' => $ids));
     * </code>
     *
     * @param array $options
     *
     * @throws \RuntimeException
     */
    public function load(array $options = array())
    {
        $userIds = $this->getOptionIds($options, 'user_ids');

        if (count($userIds) > 0) {
            // Create a new query object.
            $query = $this->db->getQuery(true);
            $query
                ->select(
                    'a.id AS user_id, a.name, a.email, a.username,  ' .
                    $query->concatenate(array('a.id', 'a.username'), ':') . ' AS slug'
                )
                ->from($this->db->quoteName('#__users', 'a'))
                ->where('a.id IN ( ' . implode(',', $userIds) . ')');

            $this->db->setQuery($query);
            $this->items = (array)$this->db->loadObjectList('user_id');

            if (count($this->items) > 0) {
                $subQuery = $this->db->getQuery(true);
                $subQuery
                    ->select('b.user_id, b.profile_key, b.profile_value')
                    ->from($this->db->quoteName('#__user_profiles', 'b'))
                    ->where('b.user_id IN ('. implode(',', $userIds) . ')');

                $this->db->setQuery($subQuery);
                $results = (array)$this->db->loadAssocList();

                foreach ($results as $result) {
                    list($p, $property) = explode('.', $result['profile_key']);
                    $this->items[$result['user_id']]->$property = stripslashes(str_replace('"', '', $result['profile_value']));
                }
            }
        }
    }

    /**
     * Return a location name where the user lives.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Library\Integration\Profiles\JoomlaProfile(\JFactory::getDbo());
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
        $item = array_key_exists($userId, $this->items);
        $profileAdapter = new JProfile();
        $profileAdapter->bind($item);

        $profile = new Profile($profileAdapter);

        return $profile->get('location');
    }

    /**
     * Create a Profile object and return it.
     *
     * <code>
     * $ids = array(1, 2, 3, 4);
     * $userId = 1;
     *
     * $profiles = new Prism\Library\Integration\Profiles\JoomlaProfile(\JFactory::getDbo());
     * $profiles->load($ids);
     *
     * $profile = $profiles->getProfile($userId);
     * </code>
     *
     * @param int $userId.
     *
     * @throws \InvalidArgumentException
     *
     * @return null|Profile
     */
    public function getProfile($userId)
    {
        if (!$userId) {
            throw new \InvalidArgumentException('Invalid user ID.');
        }

        $item = null;

        if (array_key_exists($userId, $this->items) and $this->items[$userId] !== null) {
            $profileAdapter = new JProfile();
            $profileAdapter->bind($this->items[$userId]);
            $item = new Profile($profileAdapter);
        }

        return $item;
    }

    /**
     * Return the types as array with objects.
     *
     * <code>
     * $options = array(
     *     "ids" => array(1,2,3,4,5)
     * );
     *
     * $types   = new Crowdfunding\Type\Types(\JFactory::getDbo());
     * $types->load($options);
     *
     * $types = $types->getTypes();
     * </code>
     *
     * @return array
     */
    public function getProfiles()
    {
        $results = array();

        $i = 0;
        $profileAdapter_ = new JProfile();

        foreach ($this->items as $itemData) {
            $profileAdapter = clone $profileAdapter_;
            $profileAdapter->bind($itemData);

            $item = new Profile($profileAdapter);

            $results[$i] = $item;
            $i++;
        }

        return $results;
    }

    /**
     * Call an object method if exits.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_ids' => [1,2,3,4]
     * ));
     *
     * $factory = new Prism\Library\Integration\Profiles\Factory($options, JFactory::getDbo());
     *
     * $profilesAdapter = $factory->create();
     *
     * $avatar = $profilesAdapter->getAvatar('small');
     * $link   = $profilesAdapter->getLink();
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
