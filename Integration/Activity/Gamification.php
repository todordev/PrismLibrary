<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Activities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Activity;

use Gamification\Activity\Activity;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with the activities of Gamification Platform.
 *
 * @package      Prism
 * @subpackage   Integrations\Activities
 */
class Gamification implements ActivityInterface
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
     * Initialize the object, setting a user id
     * and information about the activity.
     *
     * <code>
     * $userId = 1;
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\Gamification($userId, $content);
     * </code>
     *
     * @param  integer $userId User ID
     * @param  string  $content   Information about the activity.
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
     *     "user_id" => 1,
     *     "content" => "...",
     * );
     *
     * $activity = new Prism\Integration\Activity\Gamification();
     * $activity->bind($data);
     * </code>
     *
     * @param array $data
     */
    public function bind(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Store information about activity.
     *
     * <code>
     * $userId = 1;
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\Gamification($userId, $content);
     * $activity->store();
     * </code>
     */
    public function store()
    {
        $activity = new Activity(\JFactory::getDbo());

        $activity->setContent($this->getContent());
        $activity->setUserId($this->getUserId());

        if ($this->title !== null) {
            $activity->setTitle($this->getTitle());
        }

        if ($this->image !== null) {
            $activity->setImage($this->getImage());
        }

        if ($this->url !== null) {
            $activity->setUrl($this->getUrl());
        }

        $activity->store();
    }

    /**
     * Return an item ID.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $id = $activity->getId();
     * </code>
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the title of the activity.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $title = $activity->getTitle();
     * </code>
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Return the content of the activity.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $content = $activity->getContent();
     * </code>
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Return an image.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $image = $activity->getImage();
     * </code>
     *
     * @return string $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Return a URL that is part from activity.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $url = $activity->getUrl();
     * </code>
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Return a date when the activity has been created.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $created = $activity->getCreated();
     * </code>
     *
     * @return string $created
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Return a status of the activity.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $status = $activity->getStatus();
     * </code>
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return a user ID.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $userId = $activity->getUserId();
     * </code>
     *
     * @return int $user_id
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set an item ID.
     *
     * <code>
     * $id = 1;
     *
     * $activity = new Prism\Integration\Activity\Gamification();
     * $activity->setId($id);
     * </code>
     *
     * @param integer $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the title of the activity.
     *
     * <code>
     * $title = "...";
     *
     * $activity = new Prism\Integration\Activity\Gamification();
     * $activity->setTitle($title);
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
     * Set the content of the activity.
     *
     * <code>
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\Gamification();
     * $activity->setContent($content);
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
     * Set an image.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $activity->setImage("http://mydomain.com/images/picture.png");
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
     * Set a URL.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Gamification();
     * $activity->setUrl("http://mydomain.com/");
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
     * Set a date when the activity has been created.
     *
     * <code>
     * $created = "...";
     *
     * $activity = new Prism\Integration\Activity\Gamification();
     * $activity->setCreated($created);
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
     * Set a status of the activity.
     *
     * <code>
     * $status = "...";
     *
     * $activity = new Prism\Integration\Activity\Gamification();
     * $activity->setStatus($status);
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
     * Set an ID of a user which has made the activity.
     *
     * <code>
     * $userId = 1;
     *
     * $activity = new Prism\Integration\Activity\Gamification();
     * $activity->setUserId($userId);
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
