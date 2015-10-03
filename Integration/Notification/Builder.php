<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@prism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Notification;

use Joomla\Utilities\ArrayHelper;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods which creates social profile object,
 * based on social extension name.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
 */
class Builder
{
    protected $config = array();
    protected $notification;

    /**
     * Initialize the object.
     *
     * <code>
     * $options = array(
     *    "social_platform" => "socialcommunity",
     *    "user_id" => 1
     * );
     *
     * $notificationBuilder = new Prism\Integration\Notification\Builder($options);
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
     * $notificationBuilder = new Prism\Integration\Notification\Builder($options);
     * $notificationBuilder->build();
     *
     * $notification = $notificationBuilder->getNotification();
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
                $notification = new SocialCommunity($userId);
                $notification->setUrl($url);
                $notification->setImage($image);
                break;

            case 'gamification':
                $notification = new Gamification($userId);
                $notification->setTitle($title);
                $notification->setUrl($url);
                $notification->setImage($image);
                break;

            case 'jomsocial':

                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $notification = new JomSocial($userId);
                $notification->setDb(\JFactory::getDbo());

                break;

            case 'easysocial':
                $notification = new EasySocial($userId);
                $notification->setDb(\JFactory::getDbo());
                break;

            default:
                $notification = null;
                break;
        }

        $this->notification = $notification;
    }

    /**
     * Return a notification object.
     *
     * <code>
     * $options = array(
     *    "social_platform" => "socialcommunity",
     *    "user_id" => 1
     * );
     *
     * $notificationBuilder = new Prism\Integration\Notification\Builder($options);
     * $notificationBuilder->build();
     *
     * $notification = $notificationBuilder->getNotification();
     * </code>
     *
     * @return null|NotificationInterface
     */
    public function getNotification()
    {
        return $this->notification;
    }
}
