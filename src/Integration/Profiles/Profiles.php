<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Integration\Profiles;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with social profiles.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 *
 * @deprecated v1.20
 */
class Profiles
{
    /**
     * @var ProfilesInterface
     */
    protected $profiles;

    protected $mapping;

    /**
     * Initialize the object.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_ids' => array(1,2,3,4)
     * ));
     *
     * $factory = new Prism\Library\Integration\Profiles\Factory($options);
     *
     * $profilesAdapter = $factory->create();
     *
     * $profiles = new Prism\Library\Integration\Profiles\Profiles($profilesAdapter);
     * </code>
     *
     * @param ProfilesInterface $profiles
     */
    public function __construct(ProfilesInterface $profiles)
    {
        $this->profiles = $profiles;
    }
}
