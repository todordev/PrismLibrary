<?php
/**
 * @package   Prism\Library\Prism\Authorization\Rule
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Authorization\Rule;

use Prism\Library\Prism\Contract\Categorised;
use Prism\Library\Prism\Contract\Authorization\Authorizable;
use Prism\Library\Prism\Contract\Authorization\AuthorizationRule;
use Prism\Library\Prism\Contract\Domain\Entity;

/**
 * Authorization for an user to view an entity.
 *
 * @package Prism\Library\Prism\Authorization\Rule
 */
final class ViewAccess implements AuthorizationRule
{
    private array $groups;

    public function __construct(array $groups)
    {
        $this->groups = $groups;
    }

    public function authorize(Entity $entity): bool
    {
        $item = $entity->item();

        // If no access filter is set, the layout takes some responsibility for display of limited information.
        if ($item instanceof Categorised && $item instanceof Authorizable) {
            $viewAllowed = in_array($item->getAccess(), $this->groups, true) && in_array($item->category()->getAccess(),  $this->groups, true);
        } elseif ($item instanceof Authorizable) {
            $viewAllowed = in_array($item->getAccess(), $this->groups, true);
        } else {
            $viewAllowed = false;
        }

        return $viewAllowed;
    }
}
