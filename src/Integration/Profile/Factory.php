<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profile;

use Joomla\Registry\Registry;
use Prism\Filesystem\Helper;
use Prism\Integration\Profile\Adapter;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods which creates social profile object,
 * based on social extension name.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
final class Factory
{
    /**
     * @var \JDatabaseDriver
     */
    protected $db;

    /**
     * @var Registry
     */
    protected $options;

    protected $keys;
    protected $userId;

    /**
     * Initialize the object.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_id'  => 1
     * ));
     *
     * $factory = new Prism\Integration\Profile\Factory($options);
     * </code>
     *
     * @param  Registry  $options Options used in the process of building profile object.
     * @param  \JDatabaseDriver  $db
     */
    public function __construct(Registry $options, \JDatabaseDriver $db = null)
    {
        $this->options = $options;
        $this->db      = $db ?: \JFactory::getDbo();
        $this->keys    = $this->options->get('keys');
        $this->userId  = $this->options->get('user_id');
    }

    /**
     * Build a social profile object.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_id'  => 1
     * ));
     *
     * $factory = new Prism\Integration\Profile\Factory($options);
     * $profile = $factory->create();
     * </code>
     *
     * @throws \RuntimeException
     */
    public function create()
    {
        $keys = (is_array($this->keys) and count($this->keys) > 0) ? $this->keys : $this->userId;

        switch ($this->options->get('platform')) {
            case 'socialcommunity':
                jimport('Socialcommunity.init');

                $keys = (is_array($this->keys) and count($this->keys) > 0) ? $this->keys : ['user_id' => $this->userId];

                $profile = new Socialcommunity($this->db);
                $profile->load($keys);

                /** @var  $params Registry */
                $params = \JComponentHelper::getParams('com_socialcommunity');
                $filesystemHelper = new Helper($params);

                $url   = $filesystemHelper->getMediaFolderUri();
                $profile->setMediaUrl($url);
                break;

            case 'gravatar':
                $profile = new Gravatar($this->db);
                $profile->load($keys);
                break;

            case 'kunena':
                $profile = new Kunena($this->db);
                $profile->load($keys);
                break;

            case 'jomsocial':
                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $profile = new JomSocial($this->db);
                $profile->load($keys);

                // Load language file.
                $lang = \JFactory::getLanguage();
                $lang->load('com_community.country', JPATH_BASE);
                break;

            case 'easysocial':
                $profile = new EasySocial($this->db);
                $profile->load($keys);
                break;

            case 'easyprofile':
                $profile = new EasyProfile($this->db);
                $profile->load($keys);
                break;

            case 'communitybuilder':
                $profile = new CommunityBuilder($this->db);
                $profile->load($keys);
                break;

            case 'joomlaprofile':
                $profile = new Adapter\JoomlaProfile($this->db);
                $profile->load($keys);
                break;

            default:
                $profile = null;
                break;
        }

        return $profile;
    }
}
