<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@prism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
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
     * $notificationBuilder = new Prism\Integration\Notification\Builder($options);
     * $notificationBuilder->build();
     *
     * $notification = $notificationBuilder->getNotification();
     * </code>
     */
    public function build()
    {
        $type   = ArrayHelper::getValue($this->config, "social_platform");
        $userId = ArrayHelper::getValue($this->config, "user_id");

        switch ($type) {

            case "socialcommunity":

                \JLoader::register("Prism\\Integration\\Notification\\SocialCommunity", JPATH_LIBRARIES."/prism/integration/notification/socialcommunity.php");
                $notification = new SocialCommunity($userId);

                break;

            case "gamification":

                \JLoader::register("Prism\\Integration\\Notification\\Gamification", JPATH_LIBRARIES."/prism/integration/notification/gamification.php");
                $notification = new Gamification($userId);

                break;

            case "jomsocial":

                // Register JomSocial Router
                if (!class_exists("CRoute")) {
                    \JLoader::register("CRoute", JPATH_SITE."/components/com_community/libraries/core.php");
                }

                \JLoader::register("Prism\\Integration\\Notification\\JomSocial", JPATH_LIBRARIES."/prism/integration/notification/jomsocial.php");
                $notification = new JomSocial($userId);
                $notification->setDb(\JFactory::getDbo());

                break;

            case "easysocial":

                \JLoader::register("Prism\\Integration\\Notification\\EasySocial", JPATH_LIBRARIES."/prism/integration/notification/easysocial.php");
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
     * @return null|object
     */
    public function getNotification()
    {
        return $this->notification;
    }
}
