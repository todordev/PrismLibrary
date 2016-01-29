<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Activities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Activity;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with the activities of JomSocial.
 *
 * @package      Prism
 * @subpackage   Integrations\Activities
 */
class JomSocial implements ActivityInterface
{
    protected $id;

    /**
     * Information about activity.
     * !!required
     *
     * @var string
     */
    protected $content;

    /**
     * Application name and task.
     * Example: com_vipquotes.post
     * !!required
     *
     * @var string
     */
    protected $app;

    /**
     * This is the status of the activity.
     * @var integer
     */
    protected $archived = 0;

    /**
     * This is the user that has done the activity.
     * !!required
     *
     * @var integer
     */
    protected $actorId;

    protected $created;

    /**
     * Database driver.
     *
     * @var \JDatabaseDriver
     */
    protected $db;

    /**
     * Initialize the object, setting a user id
     * and information about the activity.
     *
     * <code>
     * $userId = 1;
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\JomSocial($userId, $content);
     * </code>
     * 
     * @param  integer $userId User ID
     * @param  string  $content Information about the activity.
     */
    public function __construct($userId = 0, $content = '')
    {
        $this->actorId = $userId;
        $this->content = $content;
    }

    /**
     * Set a database driver.
     * 
     * <code>
     * $userId = 1;
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\JomSocial($userId, $content);
     * $activity->setDb(JFactory::getDbo());
     * </code>
     * 
     * @param \JDatabaseDriver $db
     *
     * @return self
     */
    public function setDb(\JDatabaseDriver $db)
    {
        $this->db = $db;

        return $this;
    }

    /**
     * Store information about activity.
     *
     * <code>
     * $userId = 1;
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\JomSocial($userId, $content);
     * $activity->setDb(JFactory::getDbo());
     * $activity->store();
     * </code>
     *
     * @throws \RuntimeException
     */
    public function store()
    {
        if (!$this->app) {
            throw new \RuntimeException(\JText::_('LIB_PRISM_ERROR_INVALID_JOMSOCIAL_APP'));
        }

        $query = $this->db->getQuery(true);

        $date = new \JDate();

        $query
            ->insert($this->db->quoteName('#__community_activities'))
            ->set($this->db->quoteName('actor') . '=' . (int)$this->actorId)
            ->set($this->db->quoteName('content') . '=' . $this->db->quote($this->content))
            ->set($this->db->quoteName('archived') . '=' . $this->db->quote($this->archived))
            ->set($this->db->quoteName('app') . '=' . $this->db->quote($this->app))
            ->set($this->db->quoteName('created') . '=' . $this->db->quote($date->toSql()));

        $this->db->setQuery($query);
        $this->db->execute();

        // Get the ID of the record.
        $this->id = $this->db->insertid();
    }

    /**
     * Return an item ID.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\JomSocial();
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
     * $activity = new Prism\Integration\Activity\JomSocial();
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
     * Return a date when the activity has been created.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\JomSocial();
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
     * $activity = new Prism\Integration\Activity\JomSocial();
     * $status = $activity->getStatus();
     * </code>
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->archived;
    }

    /**
     * Return an actor ID.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\JomSocial();
     * $actorId = $activity->getUserId();
     * </code>
     *
     * @return int $actorId
     */
    public function getUserId()
    {
        return $this->actorId;
    }

    /**
     * Set the content of the activity.
     *
     * <code>
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\JomSocial();
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
     * Set a date when the activity has been created.
     *
     * <code>
     * $created = "...";
     *
     * $activity = new Prism\Integration\Activity\JomSocial();
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
     * $activity = new Prism\Integration\Activity\JomSocial();
     * $activity->setStatus($status);
     * </code>
     *
     * @param integer $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->archived = $status;

        return $this;
    }

    /**
     * Set an ID of a user which has made the activity.
     *
     * <code>
     * $actorId = 1;
     *
     * $activity = new Prism\Integration\Activity\JomSocial();
     * $activity->setUserId($userId);
     * </code>
     *
     * @param integer $userId
     *
     * @return self
     */
    public function setUserId($userId)
    {
        $this->actorId = $userId;

        return $this;
    }

    /**
     * Set the name of the application that has made the activity.
     *
     * <code>
     * $app = "...";
     *
     * $activity = new Prism\Integration\Activity\JomSocial();
     * $activity->setApp($app);
     * </code>
     *
     * @param string $app
     *
     * @return self
     */
    public function setApp($app)
    {
        $this->app = $app;

        return $this;
    }
}
