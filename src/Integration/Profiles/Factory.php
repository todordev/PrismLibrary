<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Profiles;

use Joomla\Registry\Registry;
use Prism\Library\Prism\Filesystem\Helper;
use Prism\Library\Prism\Integration\Profiles\Adapter;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods which creates social profiles object,
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

    protected $userIds = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_ids' => array(1,2,3)
     * ));
     *
     * $factory = new Prism\Library\Prism\Integration\Profiles\Factory($options);
     * </code>
     *
     * @param  Registry  $options Options used in the process of building profile object.
     * @param  \JDatabaseDriver  $db
     */
    public function __construct(Registry $options, \JDatabaseDriver $db = null)
    {
        $this->options = $options;
        $this->db      = $db ?: \JFactory::getDbo();
        $this->userIds = $this->options->get('user_ids', array());
    }

    /**
     * Build a social profile object.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_ids' => array(1,2,3)
     * ));
     *
     * $factory = new Prism\Library\Prism\Integration\Profiles\Factory($options);
     * $profile = $factory->create();
     * </code>
     *
     * @throws \RuntimeException
     */
    public function create()
    {
        switch ($this->options->get('platform')) {
            case 'socialcommunity':
                jimport('Socialcommunity.init');

                /** @var  $params Registry */
                $params = \JComponentHelper::getParams('com_socialcommunity');
                $filesystemHelper = new Helper($params);

                $url   = $filesystemHelper->getMediaFolderUri();

                $profiles = new Socialcommunity($this->db);
                $profiles->load($this->userIds);
                $profiles->setMediaUrl($url);
                break;

            case 'gravatar':
                $profiles = new Gravatar($this->db);
                $profiles->load($this->userIds);
                break;

            case 'kunena':
                $profiles = new Kunena($this->db);
                $profiles->load($this->userIds);
                break;

            case 'jomsocial':
                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $profiles = new JomSocial($this->db);
                $profiles->load($this->userIds);
                break;

            case 'easysocial':
                $profiles = new EasySocial($this->db);
                $profiles->load($this->userIds);
                break;

            case 'easyprofile':
                $profiles = new EasyProfile($this->db);
                $profiles->load($this->userIds);
                break;

            case 'communitybuilder':
                $profiles = new CommunityBuilder($this->db);
                $profiles->load($this->userIds);
                break;

            case 'joomlaprofile':
                $profiles = new Adapter\JoomlaProfile($this->db);
                $profiles->load($this->userIds);
                break;

            default:
                $profiles = null;
                break;
        }

        return $profiles;
    }
}
