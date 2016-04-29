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

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with the EasySocial notifications.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
 */
class EasySocial implements NotificationInterface
{
    use TableTrait;

    protected $id;

    protected $uid;

    protected $title;
    protected $content;

    protected $type;
    protected $cmd;
    protected $state = 0;
    protected $created;

    protected $image;
    protected $url;

    protected $actorId;
    protected $actorType = 'user';

    protected $targetId;
    protected $targetType = 'user';

    protected $contextId;
    protected $contextType;

    /**
     * Initialize the object.
     *
     * <code>
     * $userId = 1;
     * $content = "....";
     *
     * $notification = new Prism\Integration\Notification\EasySocial($userId, $content);
     * </code>
     *
     * @param  integer $userId User ID
     * @param  string  $content Notice to user.
     */
    public function __construct($userId = 0, $content = '')
    {
        $this->targetId = $userId;
        $this->content  = $content;
    }

    /**
     * Store a notification to database.
     *
     * <code>
     * $userId = 1;
     * $content = "....";
     *
     * $notification = new Prism\Integration\Notification\EasySocial($userId, $content);
     * $notification->setDb(JFactory::getDbo());
     *
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

        $query = $this->db->getQuery(true);

        $date = new \JDate();

        $query
            ->insert($this->db->quoteName('#__social_notifications'))
            ->set($this->db->quoteName('uid') . '=' . (int)$this->uid)
            ->set($this->db->quoteName('actor_id') . '=' . (int)$this->actorId)
            ->set($this->db->quoteName('actor_type') . '=' . $this->db->quote($this->actorType))
            ->set($this->db->quoteName('target_id') . '=' . (int)$this->targetId)
            ->set($this->db->quoteName('target_type') . '=' . $this->db->quote($this->targetType))
            ->set($this->db->quoteName('content') . '=' . $this->db->quote($this->content))
            ->set($this->db->quoteName('cmd') . '=' . $this->db->quote($this->cmd))
            ->set($this->db->quoteName('type') . '=' . $this->db->quote($this->type))
            ->set($this->db->quoteName('url') . '=' . $this->db->quote($this->url))
            ->set($this->db->quoteName('state') . '=' . (int)$this->state)
            ->set($this->db->quoteName('created') . '=' . $this->db->quote($date->toSql()));

        if ($this->image !== null) {
            $query->set($this->db->quoteName('image') . '=' . $this->db->quote($this->image));
        }

        if ($this->title !== null) {
            $query->set($this->db->quoteName('title') . '=' . $this->db->quote($this->title));
        }

        $this->db->setQuery($query);
        $this->db->execute();

        $this->id = $this->db->insertid();
    }

    /**
     * Return item ID.
     *
     * <code>
     * $userId = 1;
     * $content = "....";
     *
     * $notification = new Prism\Integration\Notification\EasySocial($userId, $content);
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
     * Return the title of the notifications.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * Return the type of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $type = $notification->getType();
     * </code>
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return the command of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $cmd = $notification->getCmd();
     * </code>
     *
     * @return string $cmd
     */
    public function getCmd()
    {
        return $this->cmd;
    }

    /**
     * Return the status of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $status = $notification->getStatus();
     * </code>
     *
     * @return string $state
     */
    public function getStatus()
    {
        return $this->state;
    }

    /**
     * Return a date where the notification has been created.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * Return an image that is part of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * Return an actor ID.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $actorId      = $notification->getActorId();
     * </code>
     *
     * @return int $actorId
     */
    public function getActorId()
    {
        return $this->actorId;
    }

    /**
     * Return an actor type.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $actorType    = $notification->getActorType();
     * </code>
     *
     * @return string $actorType
     */
    public function getActorType()
    {
        return $this->actorType;
    }

    /**
     * Return a target user ID.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $targetId    = $notification->getTargetId();
     * </code>
     *
     * @return int $targetId
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * Return a target type.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $targetType   = $notification->getTargetType();
     * </code>
     *
     * @return string $targetType
     */
    public function getTargetType()
    {
        return $this->targetType;
    }

    /**
     * Return a context ID.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $contextId    = $notification->getContextId();
     * </code>
     *
     * @return int $contextId
     */
    public function getContextId()
    {
        return $this->contextId;
    }

    /**
     * Return a context type.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $contextType  = $notification->getContextType();
     * </code>
     *
     * @return string $contextType
     */
    public function getContextType()
    {
        return $this->contextType;
    }

    /**
     * Return an unique item ID, which comes from EasySocial database.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $itemId  = $notification->getItemId();
     * </code>
     *
     * @return int $uid
     */
    public function getItemId()
    {
        return $this->uid;
    }

    /**
     * Set notification title.
     *
     * <code>
     * $title = "...";
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * Set notification content.
     *
     * <code>
     * $content = "...";
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * Set notification type.
     *
     * <code>
     * $type = "...";
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setType($type);
     * </code>
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set notification command.
     *
     * <code>
     * $cmd = "...";
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setCmd($cmd);
     * </code>
     *
     * @param string $cmd
     *
     * @return self
     */
    public function setCmd($cmd)
    {
        $this->cmd = $cmd;

        return $this;
    }

    /**
     * Set notification status.
     *
     * <code>
     * $status = 1;
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setStatus($status);
     * </code>
     *
     * @param int $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->state = $status;

        return $this;
    }

    /**
     * Set a date when the notification has been created.
     *
     * <code>
     * $created = "2014-01-01";
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * Set a link to an image which will be part of the notification.
     *
     * <code>
     * $image = "...";
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * $notification = new Prism\Integration\Notification\EasySocial();
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
     * Set an ID of an actor.
     *
     * <code>
     * $actorId = 1;
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setActorId($actorId);
     * </code>
     *
     * @param int $actorId
     *
     * @return self
     */
    public function setActorId($actorId)
    {
        $this->actorId = $actorId;

        return $this;
    }

    /**
     * Set a type of an actor.
     *
     * <code>
     * $actorType = "...";
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setActorType($actorType);
     * </code>
     *
     * @param string $actorType
     *
     * @return self
     */
    public function setActorType($actorType)
    {
        $this->actorType = $actorType;

        return $this;
    }

    /**
     * Set an ID of a target.
     *
     * <code>
     * $targetId = 1;
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setTargetId($targetId);
     * </code>
     *
     * @param int $targetId
     *
     * @return self
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;

        return $this;
    }

    /**
     * Set a type of the target.
     *
     * <code>
     * $targetType = "...";
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setTargetType($targetType);
     * </code>
     *
     * @param string $targetType
     *
     * @return self
     */
    public function setTargetType($targetType)
    {
        $this->targetType = $targetType;

        return $this;
    }

    /**
     * Set an ID of a context.
     *
     * <code>
     * $contextId = 1;
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setContextId($contextId);
     * </code>
     *
     * @param int $contextId
     *
     * @return self
     */
    public function setContextId($contextId)
    {
        $this->contextId = $contextId;

        return $this;
    }

    /**
     * Set a type of a context.
     *
     * <code>
     * $contextType = "...";
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setContextType($contextType);
     * </code>
     *
     * @param string $contextType
     *
     * @return self
     */
    public function setContextType($contextType)
    {
        $this->contextType = $contextType;

        return $this;
    }

    /**
     * This represents the unique id of the item, which comes from EasySocial database.
     *
     * <code>
     * $uid = 1;
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setItemId($uid);
     * </code>
     *
     * @param int $uid
     *
     * @return self
     */
    public function setItemId($uid)
    {
        $this->uid = (int)$uid;

        return $this;
    }

    /**
     * Return a target user ID.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $targetId    = $notification->getUserId();
     * </code>
     *
     * @return int $targetId
     */
    public function getUserId()
    {
        return $this->getTargetId();
    }

    /**
     * Set an ID of a target.
     *
     * <code>
     * $targetId = 1;
     *
     * $notification = new Prism\Integration\Notification\EasySocial();
     * $notification->setUserId($targetId);
     * </code>
     *
     * @param int $userId
     *
     * @return self
     */
    public function setUserId($userId)
    {
        return $this->setTargetId($userId);
    }
}
