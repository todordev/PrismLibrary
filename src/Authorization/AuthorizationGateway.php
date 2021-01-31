<?php
/**
 * @package      Prism\Library\Fundocs
 * @subpackage   Service
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Authorization;

use Joomla\CMS\User\User;
use Prism\Library\Prism\Contract\Authorization\AuthorizationRule;
use Prism\Library\Prism\Contract\Domain\Entity;

/**
 * This class provides functionality for preparing access to items.
 *
 * @package      Prism\Library\Fundocs
 * @subpackage   Service
 */
final class AuthorizationGateway
{
    private array $actions;
    private array $authorized = [];

    /**
     * @param array $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * Assign authorization rule to an action.
     * @param string $action
     * @param AuthorizationRule $rule
     */
    public function assignAuthorization(string $action, AuthorizationRule $rule): void
    {
        if (!array_key_exists($action, $this->actions)) {
            throw new \InvalidArgumentException('The action ' . $action . ' does not exists.');
        }

        // Do now allow authorization to be overridden.
        if ($this->actions[$action] !== null) {
            throw new \InvalidArgumentException('The action ' . $action . ' already initialized.');
        }

        $this->actions[$action] = $rule;
    }

    /**
     * Add authorization rule and action.
     * @param string $action
     * @param AuthorizationRule $rule
     */
    public function addAction(string $action, AuthorizationRule $rule): void
    {
        if (array_key_exists($action, $this->actions)) {
            throw new \InvalidArgumentException('The action ' . $action . ' already exists.');
        }

        $this->actions[$action] = $rule;
    }

    /**
     * Auhtorize an entity.
     * @param Entity $entity
     * @return AuthorizationGateway
     */
    public function authorize(Entity $entity): AuthorizationGateway
    {
        $actions = [];
        /**
         * @var string $action
         * @var AuthorizationRule $validation
         */
        foreach ($this->actions as $action => $validation) {
            if (!$validation) {
                continue;
            }

            $actions[$action] = $validation->authorize($entity);
        }

        $key = $entity::class . ':' . $entity->getIdentifier()->getValue();
        $this->authorized[$key] = $actions;

        return $this;
    }

    /**
     * Authorize multiple entities.
     *
     * @param iterable $items
     * @return AuthorizationGateway
     */
    public function multiAuthorize(iterable $items): AuthorizationGateway
    {
        /** @var Entity $entity */
        foreach ($items as $entity) {
            if ($entity instanceof Entity) {
                $this->authorize($entity);
            }
        }

        return $this;
    }

    /**
     * Check for an action, is it allowed to be performed.
     *
     * @param string $action
     * @param Entity $entity
     * @return bool
     * @throws \ErrorException
     */
    public function can(string $action, Entity $entity): bool
    {
        $key = $entity::class . ':' . $entity->getIdentifier()->getValue();
        if (!array_key_exists($key, $this->authorized)) {
            $this->authorize($entity);
        }

        if (!array_key_exists($action, $this->authorized[$key])) {
            throw new \ErrorException('The action' . $action . ' does not exist.');
        }

        return $this->authorized[$key][$action];
    }
}
