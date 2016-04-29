<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@prism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Activity;

use Joomla\Utilities\ArrayHelper;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods which creates social profile object,
 * based on social extension name.
 *
 * @package      Prism
 * @subpackage   Integrations\Activities
 *
 * @deprecated v1.20
 */
class Builder
{
    protected $config = array();
    protected $activity;

    /**
     * Initialize the object.
     *
     * <code>
     * $options = array(
     *    "social_platform" => "socialcommunity",
     *    "user_id" => 1
     * );
     *
     * $activityBuilder = new Prism\Integration\Activity\Builder($options);
     * </code>
     *
     * @param  array  $config Options used in the process of building profile object.
     *
     */
    public function __construct($config = array())
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
     * $activityBuilder = new Prism\Integration\Activity\Builder($options);
     * $activityBuilder->build();
     *
     * $activity = $activityBuilder->getActivity();
     * </code>
     */
    public function build()
    {
        $type   = ArrayHelper::getValue($this->config, 'social_platform');
        $userId = ArrayHelper::getValue($this->config, 'user_id');
        $url    = ArrayHelper::getValue($this->config, 'url');
        $image  = ArrayHelper::getValue($this->config, 'image');
        $title  = ArrayHelper::getValue($this->config, 'title');

        switch ($type) {

            case 'socialcommunity':
                $activity = new SocialCommunity($userId);
                $activity->setUrl($url);
                $activity->setImage($image);
                break;

            case 'gamification':
                $activity = new Gamification($userId);
                $activity->setTitle($title);
                $activity->setUrl($url);
                $activity->setImage($image);
                break;

            case 'jomsocial':

                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $activity = new JomSocial($userId);
                $activity->setDb(\JFactory::getDbo());

                $app = ArrayHelper::getValue($this->config, 'app');
                $activity->setApp($app);

                break;

            case 'easysocial':

                $activity = new EasySocial($userId);
                $activity->setContextId($userId);

                break;

            default:
                $activity = null;
                break;
        }

        $this->activity = $activity;
    }

    /**
     * Return a activity object.
     *
     * <code>
     * $options = array(
     *    "social_platform" => "socialcommunity",
     *    "user_id" => 1
     * );
     *
     * $activityBuilder = new Prism\Integration\Activity\Builder($options);
     * $activityBuilder->build();
     *
     * $activity = $activityBuilder->getActivity();
     * </code>
     *
     * @return null|ActivityInterface
     */
    public function getActivity()
    {
        return $this->activity;
    }
}
