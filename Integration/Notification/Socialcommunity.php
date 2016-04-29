<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Notifications
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Notification;

use Prism\Database\TableTrait;
use Socialcommunity\Notification\Notification;

defined('JPATH_PLATFORM') or die;

jimport('Socialcommunity.init');

/**
 * This class provides functionality to
 * integrate extensions with the notifications of social community.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
 */
class Socialcommunity implements NotificationInterface
{
    use TableTrait;

    protected $id;
    protected $content;
    protected $image;
    protected $url;
    protected $created;
    protected $status;

    protected $user_id;

    /**
     * Initialize the object.
     *
     * <code>
     * $userId = 1;
     * $content = "....";
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity($userId, $content);
     * </code>
     *
     * @param  integer $userId User ID
     * @param  string  $content Notice to user.
     */
    public function __construct($userId = 0, $content = '')
    {
        $this->user_id = $userId;
        $this->content = $content;
    }

    /**
     * Store a notification to database.
     *
     * <code>
     * $userId = 1;
     * $content = "....";
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity($userId, $content);
     * $notification->send();
     * </code>
     *
     * @param string $content
     */
    public function send($content = '')
    {
        if ($content !== '') {
            $this->content = $content;
        }

        $notification = new Notification($this->db);

        $notification->setContent($this->content);
        $notification->setUserId($this->user_id);

        if ($this->image !== null) {
            $notification->setImage($this->image);
        }

        if ($this->url !== null) {
            $notification->setUrl($this->url);
        }

        $notification->store();
    }

    /**
     * Return item ID.
     *
     * <code>
     * $userId = 1;
     * $content = "....";
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity($userId, $content);
     * $notification->setDb(JFactory::getDbo());
     * $notification->send();
     *
     * if (!$notification->getId()) {
     * ...
     * }
     * </code>
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the content of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $content = $notification->getContent();
     * </code>
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Return an image that is part of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $image        = $notification->getImage();
     * </code>
     *
     * @return string $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Return an URL which is part of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $url          = $notification->getUrl();
     * </code>
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Return a date where the notification has been created.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $date = $notification->getCreated();
     * </code>
     *
     * @return string $created
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Return the status of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $status = $notification->getStatus();
     * </code>
     *
     * @return string $state
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return the ID of the user receiver.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $userId       = $notification->getUserId();
     * </code>
     *
     * @return int $actorId
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * This is the ID of the notification.
     *
     * <code>
     * $id = 1;
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $notification->setId($id);
     * </code>
     *
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set notification content.
     *
     * <code>
     * $content = "...";
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $notification->setContent($content);
     * </code>
     *
     * @param string $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set a link to an image which will be part of the notification.
     *
     * <code>
     * $image = "...";
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $notification->setImage($image);
     * </code>
     *
     * @param string $image
     *
     * @return self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Set a link to a page which will be part of the notification.
     *
     * <code>
     * $url = "...";
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $notification->setUrl($url);
     * </code>
     *
     * @param string $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set a date when the notification has been created.
     *
     * <code>
     * $created = "2014-01-01";
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $notification->setCreated($created);
     * </code>
     *
     * @param string $created
     *
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Set notification status.
     *
     * <code>
     * $status = 1;
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $notification->setStatus($status);
     * </code>
     *
     * @param int $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set an ID of an user that is going to receive the notification.
     *
     * <code>
     * $userId = 1;
     *
     * $notification = new Prism\Integration\Notification\Socialcommunity();
     * $notification->setUserId($userId);
     * </code>
     *
     * @param integer $userId
     *
     * @return self
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }
}
