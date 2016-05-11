<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@prism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Activity;

use Joomla\Registry\Registry;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods which creates social profile object,
 * based on social extension name.
 *
 * @package      Prism
 * @subpackage   Integrations\Activities
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
     *    'user_id'  => 1,
     *    'title'    => 'Title...',
     *    'image'    => "http://mydomain.com/image.png",
     *    'url'      => "http://mydomain.com"
     * ));
     *
     * $factory = new Prism\Integration\Activity\Factory($options);
     * </code>
     *
     * @param  Registry  $options Options used in the process of building the object.
     *
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
     *    'user_id'  => 1,
     *    'title'    => 'Title...',
     *    'image'    => "http://mydomain.com/image.png",
     *    'url'      => "http://mydomain.com",
     *    'app'      => 'my_app'
     * ));
     *
     * $factory = new Prism\Integration\Activity\Factory($options);
     * $activity = $factory->create();
     * </code>
     */
    public function create()
    {
        switch ($this->options->get('platform')) {
            case 'socialcommunity':
                $activity = new Socialcommunity($this->options->get('user_id'));
                $activity->setUrl($this->options->get('url'));
                $activity->setImage($this->options->get('image'));
                break;

            case 'gamification':
                $activity = new Gamification($this->options->get('user_id'));
                $activity->setTitle($this->options->get('title'));
                $activity->setUrl($this->options->get('url'));
                $activity->setImage($this->options->get('image'));
                break;

            case 'jomsocial':
                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $activity = new JomSocial($this->options->get('user_id'));
                $activity->setDb(\JFactory::getDbo());

                $activity->setApp($this->options->get('app'));
                break;

            case 'easysocial':
                $activity = new EasySocial($this->options->get('user_id'));
                $activity->setContextId($this->options->get('user_id'));
                break;

            default:
                $activity = null;
                break;
        }

        return $activity;
    }
}
