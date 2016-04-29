<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profiles;

use Joomla\Registry\Registry;
use Prism\Filesystem\Helper;

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
     * @var Registry
     */
    protected $options;

    /**
     * Initialize the object.
     *
     * <code>
     * $options = new Joomla\Registry\Registry(array(
     *    'platform' => 'socialcommunity',
     *    'user_ids' => array(1,2,3)
     * ));
     *
     * $factory = new Prism\Integration\Profiles\Factory($options);
     * </code>
     *
     * @param  Registry  $options Options used in the process of building profile object.
     */
    public function __construct(Registry $options)
    {
        $this->options = $options;
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
     * $factory = new Prism\Integration\Profiles\Factory($options);
     * $profile = $factory->create();
     * </code>
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

                $profiles = new Socialcommunity(\JFactory::getDbo());
                $profiles->load($this->options->get('user_ids'));
                $profiles->setMediaUrl($url);
                break;

            case 'gravatar':
                $profiles = new Gravatar(\JFactory::getDbo());
                $profiles->load($this->options->get('user_ids'));
                break;

            case 'kunena':
                $profiles = new Kunena(\JFactory::getDbo());
                $profiles->load($this->options->get('user_ids'));
                break;

            case 'jomsocial':
                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $profiles = new JomSocial(\JFactory::getDbo());
                $profiles->load($this->options->get('user_ids'));
                break;

            case 'easysocial':
                $profiles = new EasySocial(\JFactory::getDbo());
                $profiles->load($this->options->get('user_ids'));
                break;

            case 'easyprofile':
                $profiles = new EasyProfile(\JFactory::getDbo());
                $profiles->load($this->options->get('user_ids'));
                break;

            case 'communitybuilder':
                $profiles = new CommunityBuilder(\JFactory::getDbo());
                $profiles->load($this->options->get('user_ids'));
                break;

            default:
                $profiles = null;
                break;
        }

        return $profiles;
    }
}
