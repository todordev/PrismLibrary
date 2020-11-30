<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Notifications
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Notification;

use Joomla\Registry\Registry;
use Socialcommunity\Notification\Mapper;
use Socialcommunity\Notification\Repository;
use Socialcommunity\Notification\Gateway\NotificationGateway;
use Socialcommunity\Notification\Notification as SCNotification;

/**
 * This class provides functionality to
 * integrate extensions with Social Community notifications.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
 */
class Socialcommunity extends Notification
{
    protected $user_id;
    protected $gateway;

    /**
     * Initialize the object.
     *
     * <code>
     * $options = new Registry([
     *      'content' => '....',
     *      'created_at' => '2012-12-12',
     *      'status' => 'new',
     *      'image' => '...',
     *      'url' => '...',
     *      'target_id' => 2
     * ]);
     *
     * $notification = new Prism\Library\Prism\Integration\Notification\Socialcommunity($options);
     * </code>
     *
     * @param  Registry $options
     */
    public function __construct(Registry $options)
    {
        parent::__construct($options);

        $this->user_id = $options->get('target_id');
    }

    /**
     * Set database gateway.
     *
     * @param NotificationGateway $gateway
     */
    public function setGateway(NotificationGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Store a notification to database.
     */
    public function send()
    {
        $notification = new SCNotification();

        $notification->setContent($this->content);
        $notification->setUserId($this->user_id);

        if ($this->image !== null) {
            $notification->setImage($this->image);
        }

        if ($this->url !== null) {
            $notification->setUrl($this->url);
        }

        $repository = new Repository(new Mapper($this->gateway));
        $repository->store($notification);
    }

    /**
     * Return the ID of the user receiver.
     *
     * @return int $actorId
     */
    public function getTargetId()
    {
        return $this->user_id;
    }

    /**
     * Set an ID of an user that is going to receive the notification.
     *
     * @param int $targetId
     *
     * @return self
     */
    public function setTargetId($targetId)
    {
        $this->user_id = $targetId;

        return $this;
    }
}
