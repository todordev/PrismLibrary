<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\Integration\Profile;

use Joomla\Utilities\ArrayHelper;
use Joomla\Registry\Registry;

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
     * $profileBuilder = new Prism\Integration\Profile\Builder($options);
     * $profileBuilder->build();
     *
     * $profile = $profileBuilder->getProfile();
     * </code>
     */
    public function build()
    {
        $type   = ArrayHelper::getValue($this->config, "social_platform");
        $userId = ArrayHelper::getValue($this->config, "user_id");

        switch ($type) {

            case "socialcommunity":

                jimport("socialcommunity.init");

                /** @var  $params Registry */
                $params = \JComponentHelper::getParams("com_socialcommunity");
                $path   = $params->get("images_directory", "/images/profiles");

                \JLoader::register("Prism\\Integration\\Profile\\SocialCommunity", JPATH_LIBRARIES . '/prism/integration/profile/socialcommunity.php');
                $profile = new SocialCommunity(\JFactory::getDbo());
                $profile->load($userId);
                $profile->setPath($path);

                break;

            case "gravatar":

                \JLoader::register("Prism\\Integration\\Profile\\Gravatar", JPATH_LIBRARIES . '/prism/integration/profile/gravatar.php');
                $profile = new Gravatar(\JFactory::getDbo());
                $profile->load($userId);

                break;

            case "kunena":

                \JLoader::register("Prism\\Integration\\Profile\\Kunena", JPATH_LIBRARIES . '/prism/integration/profile/kunena.php');
                $profile = new Kunena(\JFactory::getDbo());
                $profile->load($userId);

                break;

            case "jomsocial":

                // Register JomSocial Router
                if (!class_exists("CRoute")) {
                    \JLoader::register("CRoute", JPATH_SITE."/components/com_community/libraries/core.php");
                }

                \JLoader::register("Prism\\Integration\\Profile\\JomSocial", JPATH_LIBRARIES . '/prism/integration/profile/jomsocial.php');
                $profile = new JomSocial(\JFactory::getDbo());
                $profile->load($userId);

                break;

            case "easysocial":

                \JLoader::register("Prism\\Integration\\Profile\\EasySocial", JPATH_LIBRARIES . '/prism/integration/profile/easysocial.php');
                $profile = new EasySocial(\JFactory::getDbo());
                $profile->load($userId);

                break;

            case "easyprofile":

                \JLoader::register("Prism\\Integration\\Profile\\EasyProfile", JPATH_LIBRARIES . '/prism/integration/profile/easyprofile.php');
                $profile = new EasyProfile(\JFactory::getDbo());
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
     * @return null|object
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
