<?php
/**
 * @package      Prism\Library\Prism\Integration
 * @subpackage   Notification
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Notification;

use Prism\Library\Prism\Domain\Entity;
use Prism\Library\Prism\Domain\EntityId;
use Joomla\Registry\Registry;

/**
 * This class provides functionality to
 * integrate extensions with Social Community notifications.
 *
 * @package      Prism\Library\Prism\Integration
 * @subpackage   Notification
 */
abstract class Notification implements Entity
{
    use EntityId;

    protected $content;
    protected $image;
    protected $url;
    protected $created_at;
    protected $status;

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
     * ]);
     *
     * $notification = new Prism\Library\Prism\Integration\Notification\Socialcommunity($options);
     * </code>
     *
     * @param  Registry $options
     */
    public function __construct(Registry $options)
    {
        $this->id = $options->get('id');
        $this->content = $options->get('content');
        $this->image = $options->get('image');
        $this->url = $options->get('url');
        $this->created_at = $options->get('created_at');
        $this->status = $options->get('status');
    }

    /**
     * Store a notification to database.
     */
    abstract public function send();

    /**
     * Return the content of the notification.
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
     * @return string $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Return an URL which is part of the notification.
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
     * @return string $created
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Return the status of the notification.
     *
     * @return string $state
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set notification content.
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
     * @param string $date
     *
     * @return self
     */
    public function setCreatedAt($date)
    {
        $this->created_at = $date;

        return $this;
    }

    /**
     * Set notification status.
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
}
