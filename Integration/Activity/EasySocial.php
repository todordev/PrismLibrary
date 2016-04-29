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

\JLoader::register('Foundry', JPATH_ROOT . '/administrator/components/com_easysocial/includes/foundry.php');

/**
 * This class provides functionality to
 * integrate extensions with the activities of EasySocial.
 *
 * @package      Prism
 * @subpackage   Integrations\Activities
 */
class EasySocial implements ActivityInterface
{
    protected $title;
    protected $content;

    /**
     * Specify that stream items should be available site wide to everyone like a broadcast message.
     *
     * @var boolean
     */
    protected $siteWide = true;

    /**
     * Context id of this activity stream item.
     * @var integer
     */
    protected $contextId = 0;

    /**
     * Context type of this activity stream item.
     * @var string
     */
    protected $contextType = 'story';

    /**
     *
     * Verb or action for this activity stream item.
     * Example verbs: add, edit , create , update , delete.
     *
     * @var string
     */
    protected $verb = 'create';

    /**
     * This is the object that has done the activity.
     * @var integer
     */
    protected $actorId;

    /**
     * This is the type of actor.
     * @var integer
     */
    protected $actorType = 'user';

    /**
     * This is the target item. This is usually needed if you are targeting an object.
     * Example targets: Adam posted an update on Jennifer's profile. The $targetId would be Jennifer's id.
     *
     * @var int
     */
    protected $targetId = 0;

    /**
     * The type of the stream, whether it should be rendered in full mode or mini mode.
     * Mini mode does not have a header and does not actions on the stream.
     * Example types: full or mini.
     *
     * @var string
     */
    protected $type = 'full';

    /**
     * Initialize the object, setting a user id
     * and information about the activity.
     *
     * <code>
     * $userId = 1;
     * $content = '...';
     *
     * $activity = new Prism\Integration\Activity\EasySocial($userId, $content);
     * </code>
     *
     * @param  integer $userId Target ID
     * @param  string  $content Information about the activity.
     */
    public function __construct($userId = 0, $content = '')
    {
        $this->actorId = $userId;
        $this->content = $content;
    }

    /**
     * Store information about activity.
     *
     * <code>
     * $userId = 1;
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\EasySocial($userId, $content);
     * $activity->store();
     * </code>
     *
     * @throws \RuntimeException
     */
    public function store()
    {
        // Retrieve the stream library.
        $stream = \Foundry::stream();

        // Retrieve the stream template.
        $template = $stream->getTemplate();

        // Set the actor that is generating this stream item.
        $template->setActor($this->actorId, $this->actorType);

        // Set the context type of this stream item.
        $template->setContext($this->contextId, $this->contextType);

        // Set the title.
        $template->setTitle($this->title);

        // Set the content.
        $template->setContent($this->content);

        // Set the verb / action for this stream item.
        // Example verbs: add, edit , create , update , delete.
        $template->setVerb($this->verb);

        // Set the type of the stream, whether it should be rendered in full mode or mini mode.
        // Mini mode does not have a header and does not actions on the stream.
        // Example types: full,mini
        $template->setType($this->type);

        $template->setSiteWide($this->siteWide);

        // Set target ID.
        if ($this->targetId > 0) {
            $template->setTarget($this->targetId);
        }

        $stream->add($template);
    }

    /**
     * Return a title.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\EasySocial();
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
     * Return a content.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\EasySocial();
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
     * Return a content type.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $siteWide = $activity->getSiteWide();
     * </code>
     *
     * @return string $siteWide
     */
    public function getSiteWide()
    {
        return $this->siteWide;
    }

    /**
     * Return a context type.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $contextType = $activity->getContext();
     * </code>
     *
     * @return string $contextType
     */
    public function getContextType()
    {
        return $this->contextType;
    }

    /**
     * Return a verb
     *
     * <code>
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $verb = $activity->getVerbContext();
     * </code>
     *
     * @return string $verb
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * Return an actor ID.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $actorId = $activity->getActorId();
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
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $actorType = $activity->getActorType();
     * </code>
     *
     * @return string $actorType
     */
    public function getActorType()
    {
        return $this->actorType;
    }

    /**
     * Return a user ID of the target.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $targetId = $activity->getTargetId();
     * </code>
     *
     * @return int $targetId
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * Return a activity type.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $type = $activity->getType();
     * </code>
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set a title.
     *
     * <code>
     * $title = "...";
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
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
     * Set a content.
     *
     * <code>
     * $content = "...";
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
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
     * Set a content type.
     *
     * <code>
     * $siteWide = "...";
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $activity->setSiteWide($siteWide);
     * </code>
     *
     * @param boolean $siteWide
     *
     * @return self
     */
    public function setSiteWide($siteWide)
    {
        $this->siteWide = (boolean)$siteWide;

        return $this;
    }

    /**
     * Set a context ID.
     *
     * <code>
     * $contextId = 1;
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $activity->setContextId($contextId);
     * </code>
     *
     * @param integer $contextId
     *
     * @return self
     */
    public function setContextId($contextId)
    {
        $this->contextId = $contextId;

        return $this;
    }

    /**
     * Set a context type.
     *
     * <code>
     * $contextType = "...";
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $activity->setContextType($contextType);
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
     * Set the verb/action for this stream item.
     * Example verbs: add, edit, create, update, delete.
     *
     * <code>
     * $verb = "...";
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $activity->setVerb($verb);
     * </code>
     *
     * @param string $verb
     *
     * @return self
     */
    public function setVerb($verb)
    {
        $this->verb = $verb;

        return $this;
    }

    /**
     * Set an user ID of the actor.
     *
     * <code>
     * $actorId = 1;
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $activity->setActorId($actorId);
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
     * Set an user ID of the actor.
     *
     * <code>
     * $actorType = "...";
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $activity->setActorType($actorType);
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
     * Set an user ID of the target.
     *
     * <code>
     * $targetId = 1;
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $activity->setTargetId($targetId);
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
     * Set the type of the stream, whether it should be rendered in full mode or mini mode.
     * Mini mode does not have a header and does not actions on the stream.
     * Example types: full, mini.
     *
     * <code>
     * $type = 1;
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $activity->setType($type);
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
     * Set an user ID of the target.
     *
     * <code>
     * $targetId = 1;
     *
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $activity->setUserId($targetId);
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

    /**
     * Return a user ID of the target.
     *
     * <code>
     * $activity = new Prism\Integration\Activity\EasySocial();
     * $targetId = $activity->getUserId();
     * </code>
     *
     * @return int $targetId
     */
    public function getUserId()
    {
        return $this->getTargetId();
    }
}
