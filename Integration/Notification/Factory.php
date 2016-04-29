<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@prism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Notification;

use Joomla\Registry\Registry;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods which creates social profile object,
 * based on social extension name.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
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
     * $factory = new Prism\Integration\Notification\Factory($options);
     * </code>
     *
     * @param  Registry  $options Options used in the process of building the object.
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
     *    'url'      => "http://mydomain.com"
     * ));
     *
     * $factory      = new Prism\Integration\Notification\Factory($options);
     * $notification = $factory->create();
     * </code>
     */
    public function create()
    {
        switch ($this->options->get('platform')) {
            case 'socialcommunity':
                $notification = new SocialCommunity($this->options->get('user_id'));
                $notification->setUrl($this->options->get('url'));
                $notification->setImage($this->options->get('image'));
                break;

            case 'gamification':
                $notification = new Gamification($this->options->get('user_id'));
                $notification->setTitle($this->options->get('title'));
                $notification->setUrl($this->options->get('url'));
                $notification->setImage($this->options->get('image'));
                break;

            case 'jomsocial':
                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $notification = new JomSocial($this->options->get('user_id'));
                $notification->setDb(\JFactory::getDbo());
                break;

            case 'easysocial':
                $notification = new EasySocial($this->options->get('user_id'));
                $notification->setDb(\JFactory::getDbo());
                break;

            default:
                $notification = null;
                break;
        }

        return $notification;
    }
}
