<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@prism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
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
        $type   = ArrayHelper::getValue($this->config, "social_platform");
        $userId = ArrayHelper::getValue($this->config, "user_id");

        switch ($type) {

            case "socialcommunity":

                \JLoader::register("Prism\\Integration\\Activity\\SocialCommunity", JPATH_LIBRARIES."/prism/integration/activity/socialcommunity.php");
                $activity = new SocialCommunity($userId);
                break;

            case "gamification":

                \JLoader::register("Prism\\Integration\\Activity\\Gamification", JPATH_LIBRARIES."/prism/integration/activity/gamification.php");
                $activity = new Gamification($userId);
                break;

            case "jomsocial":

                // Register JomSocial Router
                if (!class_exists("CRoute")) {
                    \JLoader::register("CRoute", JPATH_SITE."/components/com_community/libraries/core.php");
                }

                \JLoader::register("Prism\\Integration\\Activity\\JomSocial", JPATH_LIBRARIES."/prism/integration/activity/jomsocial.php");
                $activity = new JomSocial($userId);
                $activity->setDb(\JFactory::getDbo());

                $app = ArrayHelper::getValue($this->config, "app");
                $activity->setApp($app);

                break;

            case "easysocial":

                \JLoader::register("Prism\\Integration\\Activity\\EasySocial", JPATH_LIBRARIES."/prism/integration/activity/easysocial.php");
                $activity = new EasySocial($userId);

                $contextId = ArrayHelper::getValue($this->config, "context_id");
                $activity->setContextId($contextId);

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
     * @return null|object
     */
    public function getActivity()
    {
        return $this->activity;
    }
}
