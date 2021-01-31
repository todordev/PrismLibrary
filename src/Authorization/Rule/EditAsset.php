<?php
/**
 * @package   Prism\Library\Prism\Authorization\Rule
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Authorization\Rule;

use Joomla\CMS\User\User;
use Prism\Library\Prism\Contract\Domain\Entity;
use Prism\Library\Prism\Contract\Authorization\AuthorizationRule;

/**
 * Authorization for an user to edit an entity.
 *
 * @package Prism\Library\Prism\Authorization\Rule
 */
final class EditAsset implements AuthorizationRule
{
    private string $asset;
    private User $user;

    public function __construct(User $user, string $asset)
    {
        $this->asset = $asset;
        $this->user = $user;
    }

    public function authorize(Entity $entity): bool
    {
        $editAllowed = false;
        if (!$this->user->guest && $this->asset) {
            $itemAsset = $this->asset  . $entity->getIdentifier()->getValue();

            if ($this->user->authorise('core.edit', $itemAsset)) {
                $editAllowed = true;
            }
        }

        return $editAllowed;
    }
}
