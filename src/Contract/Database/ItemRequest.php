<?php
/**
 * @package   Prism\Library\Prism\Contract\Database
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Database;

use Prism\Library\Prism\Database\Dto\ItemFilters;
use Prism\Library\Prism\Domain\Identifier\Identifier;

/**
 * Interface for data transfer transfer object used with the repositories.
 *
 * @package  Prism\Library\Prism\Contract\Database
 */
interface ItemRequest
{
    public function getIdentifier(): Identifier;
    public function getFilters(): ?ItemFilters;
}
