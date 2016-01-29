<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Activities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Activity;

use Socialcommunity\Activity\Activity;

defined('JPATH_PLATFORM') or die;

jimport('Socialcommunity.init');

/**
 * This class provides functionality to
 * integrate extensions with the activities of Social Community.
 *
 * @package      Prism
 * @subpackage   Integrations\Activities
 */
class Socialcommunity implements ActivityInterface
{
    protected $id;
    protected $content;
    protected $image;
    protected $url;
    protected $created;

    protected $user_id;

    /**
     * Initialize the object, setting a user id
     * and information about the activity.
     *
     * <code>
     * $userId = 1;
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\Socialcommunity($userId, $content);
     * </code>
     *
     * @param  integer $userId User ID
     * @param  string  $content Information about the activity.
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
     * $activity = new Prism\Integration\Activity\Socialcommunity();
     * $activity->bind($data);
     * </code>
     *
     * @param array $data
     * @param array $excluded
     */
    public function bind($data, array $excluded = array())
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $excluded, true)) {
                continue;
            }

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
     * $activity = new Prism\Integration\Activity\Socialcommunity($userId, $content);
     * $activity->setDb(JFactory::getDbo());
     * $activity->store();
     * </code>
     */
    public function store()
    {
        $activity = new Activity(\JFactory::getDbo());

        $activity->set('content', $this->content);
        $activity->set('user_id', $this->user_id);

        if ($this->image !== null) {
            $activity->set('image', $this->image);
        }

        if ($this->url !== null) {
            $activity->set('url', $this->url);
        }

        $activity->store();
    }

    /**
     * Return an item ID.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Socialcommunity();
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
     * Return the content of the activity.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Socialcommunity();
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
     * $activity = new Prism\Integration\Activity\Socialcommunity();
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
     * $activity = new Prism\Integration\Activity\Socialcommunity();
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
     * $activity = new Prism\Integration\Activity\Socialcommunity();
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
     * Return a user ID.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\Socialcommunity();
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
     * $activity = new Prism\Integration\Activity\Socialcommunity();
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
     * Set the content of the activity.
     *
     * <code>
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\Socialcommunity();
     * $activity->setContent($id);
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
     * $image = "...";
     *
     * $activity = new Prism\Integration\Activity\Socialcommunity();
     * $activity->setImage($image);
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
     * $url = "...";
     *
     * $activity = new Prism\Integration\Activity\Socialcommunity();
     * $activity->setUrl($url);
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
     * $activity = new Prism\Integration\Activity\Socialcommunity();
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
     * Set an ID of a user which has made the activity.
     *
     * <code>
     * $userId = 1;
     *
     * $activity = new Prism\Integration\Activity\Socialcommunity();
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
