<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Notifications
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Notification;

use Gamification\Notification\Notification;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with the notifications of Gamification Platform.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
 */
class Gamification implements NotificationInterface
{
    protected $id;
    protected $title;
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
     * $message = "....";
     *
     * $notification = new Prism\Integration\Notification\Gamification($userId, $message);
     * </code>
     * 
     * @param  integer $userId User ID
     * @param  string  $content   Notification massage to user.
     */
    public function __construct($userId = 0, $content = '')
    {
        $this->user_id = $userId;
        $this->content = $content;
    }

    /**
     * Set values to object properties.
     * 
     * <code>
     * $data = array(
     *     "property1" => "...",
     *     "property2" => "...",
     * ....
     * );
     *
     * $notification = new Prism\Integration\Notification\Gamification();
     * $notification->bind($data);
     * </code>
     * 
     * @param array $data
     */
    public function bind(array $data)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Store a notification to database.
     *
     * <code>
     * $userId = 1;
     * $note = "....";
     *
     * $notification = new Prism\Integration\Notification\Gamification($userId, $note);
     * $notification->send();
     * </code>
     *
     * @param string $content
     */
    public function send($content = '')
    {
        if (\JString::strlen($content) > 0) {
            $this->content = $content;
        }

        $notification = new Notification(\JFactory::getDbo());

        $notification->setContent($this->getContent());
        $notification->setUserId($this->getUserId());

        if ($this->title !== null) {
            $notification->setTitle($this->getTitle());
        }

        if ($this->image !== null) {
            $notification->setImage($this->getImage());
        }

        if ($this->url !== null) {
            $notification->setUrl($this->getUrl());
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
     * $notification = new Prism\Integration\Notification\Gamification($userId, $content);
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
     * Return the title of the object where the URL points.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\Gamification();
     * $title = $notification->getTitle();
     * </code>
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Return the content of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\Gamification();
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
     * $notification = new Prism\Integration\Notification\Gamification();
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
     * $notification = new Prism\Integration\Notification\Gamification();
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
     * $notification = new Prism\Integration\Notification\Gamification();
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
     * $notification = new Prism\Integration\Notification\Gamification();
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
     * $notification = new Prism\Integration\Notification\Gamification();
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
     * $notification = new Prism\Integration\Notification\Gamification();
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
     * Set a title of the object where the URL points.
     *
     * <code>
     * $title = "...";
     *
     * $notification = new Prism\Integration\Notification\Gamification();
     * $notification->setTitle($title);
     * </code>
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set a content of the notification.
     * 
     * <code>
     * $note = "...";
     *
     * $notification = new Prism\Integration\Notification\Gamification();
     * $notification->setContent($note);
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
     * Set a link to an image, which is a part of the notification.
     *
     * <code>
     * $image = "...";
     *
     * $notification = new Prism\Integration\Notification\Gamification();
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
     * Set a link to a page, which is a part of the notification.
     *
     * <code>
     * $url = "...";
     *
     * $notification = new Prism\Integration\Notification\Gamification();
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
     * Set a date of the record when the notification has been sent.
     *
     * <code>
     * $created = "...";
     *
     * $notification = new Prism\Integration\Notification\Gamification();
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
    }

    /**
     * Set a status of the notification.
     *
     * <code>
     * $status = 1;
     *
     * $notification = new Prism\Integration\Notification\Gamification();
     * $notification->setStatus($status);
     * </code>
     * 
     * @param integer $status
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
     * $notification = new Prism\Integration\Notification\Gamification();
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
