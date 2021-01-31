<?php
/**
 * @package      Prism\Library\Fundocs\Category
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Category;

use Joomla\Registry\Registry;
use Prism\Library\Prism\Constant\Status;
use Prism\Library\Prism\Contract\Arrayable;
use Prism\Library\Prism\Contract\OwnedByUser;
use Prism\Library\Prism\Contract\Authorization\Authorizable;

/**
 * Category class.
 *
 * @package Prism\Library\Fundocs\Category
 */
final class Category implements Arrayable, OwnedByUser, Authorizable
{
    private string $title;
    private string $alias;
    private string $slug;
    private string $description;
    private int $published;
    private int $access;
    private int $userId;
    private ?Registry $params;

    /**
     * Category constructor.
     *
     * @param string $title
     * @param string $alias
     * @param string $slug
     * @param string $description
     * @param int $published
     * @param int $access
     * @param int $userId
     * @param Registry|null $params
     */
    public function __construct(
        string $title,
        string $alias = '',
        string $slug = '',
        string $description = '',
        int $published = 0,
        int $access = 0,
        int $userId = 0,
        ?Registry $params = null
    ) {
        $this->title = $title;
        $this->alias = $alias;
        $this->slug = $slug;
        $this->description = $description;
        $this->published = $published;
        $this->access = $access;
        $this->userId = $userId;
        $this->params = $params;
    }

    /**
     * Return challenge title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Return alias.
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Return category description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Check if the entity is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return ($this->published === Status::PUBLISHED);
    }

    /**
     * Return a slug.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Return the value of property Published.
     *
     * @return int
     */
    public function getState(): int
    {
        return $this->published;
    }

    /**
     * Return the access state.
     *
     * @return int
     */
    public function getAccess(): int
    {
        return $this->access;
    }

    /**
     * Return category parameters.
     *
     * @return Registry
     */
    public function getParams(): Registry
    {
        return $this->params;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'access' => $this->access,
            'alias' => $this->alias,
            'published' => $this->published,
            'created_user_id' => $this->userId,
            'params' => $this->params->toArray()
        ];
    }
}
