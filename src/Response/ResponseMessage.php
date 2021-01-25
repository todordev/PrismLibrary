<?php
/**
 * @package      Prism\Library\Prism\Response
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Response;

/**
 * Response message.
 *
 * @package Prism\Library\Prism\Response
 */
class ResponseMessage
{
    public const TYPE_INFO = 'info';
    public const TYPE_WARNING = 'warning';
    public const TYPE_ERROR = 'error';
    public const TYPE_SUCCESS = 'success';

    private string $content;
    private string $title;
    private string $type;

    public function __construct(string $content, string $title = '', string $type = self::TYPE_SUCCESS)
    {
        if (!$content) {
            throw new \InvalidArgumentException('You cannot set blank content.');
        }

        $this->content = $content;
        $this->title = $title;
        $this->type = $type;
    }

    /**
     * Return a response title.
     *
     * <code>
     * $response = new Prism\Library\Prism\Response\Json();
     * $title = $response->getTitle();
     * </code>
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set a response title to the object.
     * <code>
     * $title = "My title....";
     * $response = new Prism\Library\Prism\Response\Json();
     * $response->setTitle($title);
     * </code>
     *
     * @param string $title
     * @return ResponseMessage
     */
    public function setTitle(string $title): ResponseMessage
    {
        if (!$title) {
            throw new \InvalidArgumentException('You cannot set blank title.');
        }

        $this->title = $title;

        return $this;
    }

    /**
     * Return a response content ( message ).
     *
     * <code>
     * $response = new Prism\Library\Prism\Response\Json();
     * $content = $response->getContent();
     * </code>
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set a response content to the object.
     * <code>
     * $content = "My text....";
     * $response = new Prism\Library\Prism\Response\Json();
     * $response->setText($content);
     * </code>
     *
     * @param string $content
     * @return ResponseMessage
     */
    public function setContent(string $content): ResponseMessage
    {
        if (!$content) {
            throw new \InvalidArgumentException('You cannot set blank content.');
        }

        $this->content = $content;

        return $this;
    }

    /**
     * Set type to 'info'.
     * @return ResponseMessage
     */
    public function setTypeToInfo(): ResponseMessage
    {
        $this->setType('info');
        return $this;
    }

    /**
     * Set type to 'warning'.
     * @return ResponseMessage
     */
    public function setTypeToWarning(): ResponseMessage
    {
        $this->setType('warning');
        return $this;
    }

    /**
     * Set type to 'error'.
     * @return ResponseMessage
     */
    public function setTypeToError(): ResponseMessage
    {
        $this->setType('error');
        return $this;
    }

    /**
     * Set type to 'success'.
     * @return ResponseMessage
     */
    public function setTypeToSuccess(): ResponseMessage
    {
        $this->setType('success');
        return $this;
    }

    /**
     * Return message type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set a message type.
     *
     * @param string $type
     * @return ResponseMessage
     */
    public function setType(string $type): ResponseMessage
    {
        if (!$type) {
            throw new \InvalidArgumentException('You cannot set blank type.');
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Check for a content.
     * @return bool
     */
    public function hasContent(): bool
    {
        return $this->content ? true : false;
    }

    /**
     * Transform the object to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'content' => $this->getContent(),
            'title' => $this->getTitle(),
            'type' => $this->getType()
        ];
    }
}
