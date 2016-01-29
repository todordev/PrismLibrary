<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profile;

use Joomla\Utilities\ArrayHelper;
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
class Builder
{
    protected $config = array();
    protected $profile;

    /**
     * Initialize the object.
     *
     * <code>
     * $options = array(
     *    "social_platform" => "socialcommunity",
     *    "user_id" => 1
     * );
     *
     * $profileBuilder = new Prism\Integration\Profile\Builder($options);
     * </code>
     *
     * @param  array  $config Options used in the process of building profile object.
     *
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * Build a social profile object.
     *
     * <code>
     * $options = array(
     *    "social_platform" => "socialcommunity",
     *    "user_id" => 1
     * );
     *
     * $profileBuilder = new Prism\Integration\Profile\Builder($options);
     * $profileBuilder->build();
     *
     * $profile = $profileBuilder->getProfile();
     * </code>
     */
    public function build()
    {
        $type   = ArrayHelper::getValue($this->config, 'social_platform');
        $userId = ArrayHelper::getValue($this->config, 'user_id');

        switch ($type) {

            case 'socialcommunity':

                jimport('Socialcommunity.init');

                /** @var  $params Registry */
                $params = \JComponentHelper::getParams('com_socialcommunity');
                $filesystemHelper = new Helper($params);

                $url   = $filesystemHelper->getMediaFolderUri();

                $profile = new Socialcommunity(\JFactory::getDbo());
                $profile->load(array('user_id' => $userId));
                $profile->setMediaUrl($url);

                break;

            case 'gravatar':

                $profile = new Gravatar(\JFactory::getDbo());
                $profile->load($userId);

                break;

            case 'kunena':

                $profile = new Kunena(\JFactory::getDbo());
                $profile->load($userId);

                break;

            case 'jomsocial':

                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $profile = new JomSocial(\JFactory::getDbo());
                $profile->load($userId);

                break;

            case 'easysocial':

                $profile = new EasySocial(\JFactory::getDbo());
                $profile->load($userId);

                break;

            case 'easyprofile':
                $profile = new EasyProfile(\JFactory::getDbo());
                $profile->load($userId);
                break;

            case 'communitybuilder':
                $profile = new CommunityBuilder(\JFactory::getDbo());
                $profile->load($userId);
                break;

            default:
                $profile = null;
                break;
        }

        $this->profile = $profile;
    }

    /**
     * Return a social profile object.
     *
     * <code>
     * $options = array(
     *    "social_platform" => "socialcommunity",
     *    "user_id" => 1
     * );
     *
     * $profileBuilder = new Prism\Integration\Profile\Builder($options);
     * $profileBuilder->build();
     *
     * $profile = $profileBuilder->getProfile();
     * </code>
     *
     * @return null|ProfileInterface
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
