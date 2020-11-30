<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Integration\Profile;

use Prism\Library\Database\TableImmutable;

defined('JPATH_PLATFORM') or die;

/**
 * Abstract class of the social profiles.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
class Profile
{
    /**
     * @var TableImmutable
     */
    protected $profile;

    protected $mapping;

    /**
     * Initialize the object.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_id'  => 1
     * ));
     *
     * $factory = new Prism\Library\Integration\Profile\Factory($options);
     * </code>
     *
     * @param ProfileMapper $profile
     */
    public function __construct(ProfileMapper $profile)
    {
        $this->profile = $profile;

        $this->mapping = $this->profile->getMapping();
    }

    /**
     * Returns a property of the object or the default value if the property is not set.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_id'  => 1
     * ));
     *
     * $factory = new Prism\Library\Integration\Profile\Factory($options, JFactory::getDbo());
     *
     * $profileAdapter = $factory->create();
     * $profile   = new Prism\Library\Integration\Profile\Profile($profileAdapter);
     *
     * $userId = $profile->get("user_id");
     * $userId = $profile->get("location");
     * </code>
     *
     * @param   string $property The name of the property.
     * @param   mixed  $default  The default value.
     *
     * @return  mixed    The value of the property.
     */
    public function get($property, $default = null)
    {
        if (array_key_exists($property, $this->mapping)) {
            $p = $this->mapping[$property];
            return $this->profile->get($p);
        }

        return $default;
    }

    /**
     * Call an object method if it exits in profile adapter.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_id'  => 1
     * ));
     *
     * $factory = new Prism\Library\Integration\Profile\Factory($options, JFactory::getDbo());
     *
     * $profileAdapter = $factory->create();
     * $profile   = new Prism\Library\Integration\Profile\Profile($profileAdapter);
     *
     * $avatar = $profile->getAvatar('small');
     * $link   = $profile->getLink();
     * </code>
     *
     * @param   string $name
     * @param   array  $arguments
     *
     * @return  mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->profile, $name)) {
            return call_user_func_array(array($this->profile, $name), $arguments);
        }

        return null;
    }
}
