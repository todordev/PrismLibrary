<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profile;

use Joomla\Registry\Registry;
use Prism\Filesystem\Helper;

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
     * @var Registry
     */
    protected $options;

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
        switch ($this->options->get('platform')) {
            case 'socialcommunity':
                jimport('Socialcommunity.init');

                /** @var  $params Registry */
                $params = \JComponentHelper::getParams('com_socialcommunity');
                $filesystemHelper = new Helper($params);

                $url   = $filesystemHelper->getMediaFolderUri();

                $profile = new Socialcommunity(\JFactory::getDbo());
                $profile->load(array(
                    'user_id' => $this->options->get('user_id')
                ));

                $profile->setMediaUrl($url);
                break;

            case 'gravatar':
                $profile = new Gravatar(\JFactory::getDbo());
                $profile->load($this->options->get('user_id'));
                break;

            case 'kunena':
                $profile = new Kunena(\JFactory::getDbo());
                $profile->load($this->options->get('user_id'));
                break;

            case 'jomsocial':
                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $profile = new JomSocial(\JFactory::getDbo());
                $profile->load($this->options->get('user_id'));

                // Load language file.
                $lang = \JFactory::getLanguage();
                $lang->load('com_community.country', JPATH_BASE);
                break;

            case 'easysocial':
                $profile = new EasySocial(\JFactory::getDbo());
                $profile->load($this->options->get('user_id'));
                break;

            case 'easyprofile':
                $profile = new EasyProfile(\JFactory::getDbo());
                $profile->load($this->options->get('user_id'));
                break;

            case 'communitybuilder':
                $profile = new CommunityBuilder(\JFactory::getDbo());
                $profile->load($this->options->get('user_id'));
                break;

            default:
                $profile = null;
                break;
        }

        return $profile;
    }
}
