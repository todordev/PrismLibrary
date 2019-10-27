<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@prism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Integration\Notification\Builder;

use Joomla\Registry\Registry;
use Prism\Library\Integration\Notification\Socialcommunity;
use Prism\Library\Integration\Notification\Gamification;
use Prism\Library\Integration\Notification\Jomsocial;
use Prism\Library\Integration\Notification\Easysocial;
use Prism\Library\Integration\Notification\Notification;
use Socialcommunity\Notification\Gateway\JoomlaGateway;

/**
 * This class contains methods which creates social profile object,
 * based on social extension name.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
 */
final class Joomla
{
    private $config;
    private $data;

    /**
     * Initialize the object.
     *
     * <code>
     * $config = new Registry([
     *    "env" => 'joomla', // It could be joomla, laravel, symfony
     *    "platform" => "socialcommunity",
     * ]);
     *
     * $data = new Registry([
     *      'content' => '....',
     *      'created_at' => '2012-12-12',
     *      'status' => 'new',
     *      'image' => '...',
     *      'url' => '...',
     *      'target_id' => 2
     * ]);
     *
     * $builder = Prism\Library\Integration\Notification\Builder\Joomla($config, $data);
     * $notification = $builder->build();
     * </code>
     *
     * @param Registry $config
     * @param Registry $data
     */
    public function __construct(Registry $config, Registry $data)
    {
        $this->config = $config;
        $this->data = $data;
    }

    /**
     * Build Notification object.
     *
     * @return Notification|null
     */
    public function build()
    {
        $notification = null;
        
        switch ($this->config->get('platform')) {
            case 'socialcommunity':
                jimport('Socialcommunity.init');

                $gateway = new JoomlaGateway(\JFactory::getDbo());

                $notification = new Socialcommunity($this->data);
                $notification->setGateway($gateway);
                break;

            case 'gamification':
                jimport('Gamification.init');
                $notification = new Gamification($this->data);
                break;

            case 'jomsocial':
                // Register JomSocial Router
                if (!class_exists('CRoute')) {
                    \JLoader::register('CRoute', JPATH_SITE.'/components/com_community/libraries/core.php');
                }

                $notification = new Jomsocial($this->data);
                $notification->setDb(\JFactory::getDbo());
                break;

            case 'easysocial':
                $notification = new Easysocial($this->data);
                $notification->setDb(\JFactory::getDbo());
                break;
        }

        return $notification;
    }
}
