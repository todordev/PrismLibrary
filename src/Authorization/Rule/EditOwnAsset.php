<?php
/**
 * @package   Prism\Library\Prism\Authorization\Rule
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Authorization\Rule;

use Joomla\CMS\User\User;
use Prism\Library\Prism\Contract\Authorization\AuthorizationRule;
use Prism\Library\Prism\Contract\Domain\Entity;
use Prism\Library\Prism\Contract\OwnedByUser;

/**
 * Authorization for an user to edit own entity.
 *
 * @package Prism\Library\Prism\Authorization\Rule
 */
final class EditOwnAsset implements AuthorizationRule
{
    private User $user;
    private string $asset;

    public function __construct(User $user, string $asset)
    {
        $this->asset = $asset;
        $this->user = $user;
    }

    public function authorize(Entity $entity): bool
    {
        $item = $entity->item();

        $editOwnAllowed = false;
        if (!$this->user->guest && $this->asset && $item instanceof OwnedByUser) {
            $itemAsset = $this->asset . $entity->getIdentifier()->getValue();

            // Check general edit permission first.
            if ($this->user->id === $item->getUserId() && $this->user->authorise('core.edit.own', $itemAsset)) {
                $editOwnAllowed = true;
            }
        }

        return $editOwnAllowed;
    }
}
