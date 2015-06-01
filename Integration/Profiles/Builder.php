<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\Integration\Profiles;

use Joomla\Utilities\ArrayHelper;
use Joomla\Registry\Registry;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods which creates social profiles object,
 * based on social extension name.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
class Builder
{
    protected $config = array();
    protected $profiles;

    /**
     * Initialize the object.
     *
     * <code>
     * $options = array(
     *    "social_platform" => "socialcommunity",
     *    "users_ids" => array(1,2,3)
     * );
     *
     * $profilesBuilder = new Prism\Integration\Profiles\Builder($options);
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
     *    "users_ids" => array(1,2,3)
     * );
     *
     * $profilesBuilder = new Prism\Integration\Profiles\Builder($options);
     * $profilesBuilder->build();
     *
     * $profiles = $profilesBuilder->getProfiles();
     * </code>
     */
    public function build()
    {
        $type       = ArrayHelper::getValue($this->config, "social_platform");
        $usersIds   = ArrayHelper::getValue($this->config, "users_ids");

        switch ($type) {

            case "socialcommunity":

                jimport("socialcommunity.init");

                /** @var  $params Registry */
                $params = \JComponentHelper::getParams("com_socialcommunity");
                $path   = $params->get("images_directory", "/images/profiles");

                \JLoader::register("Prism\\Integration\\Profiles\\SocialCommunity", JPATH_LIBRARIES . '/prism/integration/profiles/socialcommunity.php');
                $profiles = new SocialCommunity(\JFactory::getDbo());
                $profiles->load($usersIds);
                $profiles->setPath($path);

                break;

            case "gravatar":

                \JLoader::register("Prism\\Integration\\Profiles\\Gravatar", JPATH_LIBRARIES . '/prism/integration/profiles/gravatar.php');
                $profiles = new Gravatar(\JFactory::getDbo());
                $profiles->load($usersIds);

                break;

            case "kunena":

                \JLoader::register("Prism\\Integration\\Profiles\\Kunena", JPATH_LIBRARIES . '/prism/integration/profiles/kunena.php');
                $profiles = new Kunena(\JFactory::getDbo());
                $profiles->load($usersIds);

                break;

            case "jomsocial":

                // Register JomSocial Router
                if (!class_exists("CRoute")) {
                    \JLoader::register("CRoute", JPATH_SITE."/components/com_community/libraries/core.php");
                }

                \JLoader::register("Prism\\Integration\\Profiles\\JomSocial", JPATH_LIBRARIES . '/prism/integration/profiles/jomsocial.php');
                $profiles = new JomSocial(\JFactory::getDbo());
                $profiles->load($usersIds);

                break;

            case "easysocial":

                \JLoader::register("Prism\\Integration\\Profiles\\EasySocial", JPATH_LIBRARIES . '/prism/integration/profiles/easysocial.php');
                $profiles = new EasySocial(\JFactory::getDbo());
                $profiles->load($usersIds);

                break;

            case "easyprofile":

                \JLoader::register("Prism\\Integration\\Profiles\\EasyProfile", JPATH_LIBRARIES . '/prism/integration/profiles/easyprofile.php');
                $profiles = new EasyProfile(\JFactory::getDbo());
                $profiles->load($usersIds);

                break;

            default:
                $profiles = null;
                break;
        }

        $this->profiles = $profiles;
    }

    /**
     * Return a social profiles object.
     *
     * <code>
     * $options = array(
     *    "social_platform" => "socialcommunity",
     *    "users_ids" => array(1,2,3)
     * );
     *
     * $profilesBuilder = new Prism\Integration\Profiles\Builder($options);
     * $profilesBuilder->build();
     *
     * $profiles = $profilesBuilder->getProfiles();
     * </code>
     *
     * @return null|object
     */
    public function getProfiles()
    {
        return $this->profiles;
    }
}
