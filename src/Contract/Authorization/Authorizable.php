<?php
/**
 * @package      Prism\Library\Prism\Contract
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Authorization;

/**
 * Interface for classes that should provide a value for access level.
 *
 * @package Prism\Library\Prism\Contract
 */
interface Authorizable
{
    public function getAccess(): int;
}
