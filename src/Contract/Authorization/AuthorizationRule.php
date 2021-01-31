<?php
/**
 * @package      Prism\Library\Prism\Contract\Authorization
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Authorization;

use Prism\Library\Prism\Contract\Domain\Entity;

/**
 * Authorization rule interface.
 *
 * @package  Prism\Library\Prism\Contract\Authorization
 */
interface AuthorizationRule
{
    public function authorize(Entity $entity): bool;
}
