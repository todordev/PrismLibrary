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
 * integrate extensions with JomSocial notifications.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
 */
class JomSocial implements NotificationInterface
{
    use TableTrait;

    protected $id;

    protected $actorId;
    protected $targetId;
    protected $content;

    protected $type = 0;
    protected $cmdType = 'notif_system_messaging';
    protected $status = 0;
    protected $created;

    protected $image;
    protected $url;
    protected $cmd_type;

    /**
     * Initialize the object.
     *
     * <code>
     * $userId = 1;
     * $content = "....";
     *
     * $notification = new Prism\Integration\Notification\JomSocial($userId, $content);
     * </code>
     *
     * @param  integer $userId A user ID of the target.
     * @param  string  $content Content of the notice to user.
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
     * $notification = new Prism\Integration\Notification\JomSocial($userId, $content);
     * $notification->setDb(\JFactory::getDbo());
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

        $params = array();
        if ($this->image !== null) {
            $params['image'] = $this->image;
        }

        if ($this->url !== null) {
            $params['url'] = $this->url;
        }

        $date = new \JDate();

        $query
            ->insert($this->db->quoteName('#__community_notifications'))
            ->set($this->db->quoteName('actor') . '=' . (int)$this->actorId)
            ->set($this->db->quoteName('target') . '=' . (int)$this->targetId)
            ->set($this->db->quoteName('content') . '=' . $this->db->quote($this->content))
            ->set($this->db->quoteName('cmd_type') . '=' . $this->db->quote($this->cmdType))
            ->set($this->db->quoteName('type') . '=' . $this->db->quote($this->type))
            ->set($this->db->quoteName('status') . '=' . (int)$this->status)
            ->set($this->db->quoteName('created') . '=' . $this->db->quote($date->toSql()));

        if (count($params) > 0) {
            $params = json_encode($params);
            $query->set($this->db->quoteName('params') . '=' . $this->db->quote($params));
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
     * $notification = new Prism\Integration\Notification\JomSocial($userId, $content);
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
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * $notification = new Prism\Integration\Notification\JomSocial();
     * $actorId      = $notification->getActorId();
     * </code>
     *
     * @return int $actorId
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Return the status of the notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * Return a target user ID.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\JomSocial();
     * $targetId    = $notification->getTargetId();
     * </code>
     *
     * @return int $targetId
     */
    public function getUserId()
    {
        return $this->targetId;
    }

    /**
     * Set notification content.
     *
     * <code>
     * $content = "...";
     *
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * $status = "...";
     *
     * $notification = new Prism\Integration\Notification\JomSocial();
     * $notification->setStatus($status);
     * </code>
     *
     * @param number $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = (int)$status;

        return $this;
    }

    /**
     * Set an ID of a target.
     *
     * <code>
     * $targetId = 1;
     *
     * $notification = new Prism\Integration\Notification\JomSocial();
     * $notification->setTargetId($targetId);
     * </code>
     *
     * @param int $userId
     *
     * @return self
     */
    public function setUserId($userId)
    {
        $this->targetId = (int)$userId;

        return $this;
    }

    /**
     * Set notification command type.
     *
     * <code>
     * $cmdType = "...";
     *
     * $notification = new Prism\Integration\Notification\JomSocial();
     * $notification->setCmdType($cmdType);
     * </code>
     *
     * @param string $cmd
     *
     * @return self
     */
    public function setCmdType($cmd)
    {
        $this->cmd_type = $cmd;

        return $this;
    }

    /**
     * Return the command type of a notification.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\JomSocial();
     * $cmdType = $notification->getCmdType();
     * </code>
     *
     * @return string $cmd_type
     */
    public function getCmdType()
    {
        return $this->cmd_type;
    }

    /**
     * Set an ID of an actor.
     *
     * <code>
     * $actorId = 1;
     *
     * $notification = new Prism\Integration\Notification\JomSocial();
     * $notification->setActorId($actorId);
     * </code>
     *
     * @param int $actorId
     *
     * @return self
     */
    public function setActorId($actorId)
    {
        $this->actorId = (int)$actorId;

        return $this;
    }

    /**
     * Return an actor ID.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * Return notification type.
     *
     * <code>
     * $type = "...";
     *
     * $notification = new Prism\Integration\Notification\JomSocial();
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
     * Return notification type.
     *
     * <code>
     * $notification = new Prism\Integration\Notification\JomSocial();
     * $type      = $notification->getType();
     * </code>
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
