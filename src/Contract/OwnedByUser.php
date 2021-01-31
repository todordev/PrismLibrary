<?php
/**
 * @package      Prism\Library\Prism\Contract
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract;

/**
 * Interface for classes that should provide an access data.
 *
 * @package Prism\Library\Prism\Contract
 */
interface OwnedByUser
{
    public function getUserId(): int;
}
