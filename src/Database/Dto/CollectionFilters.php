<?php
/**
 * @package      Prism\Library\Prism\Database
 * @subpackage   Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database\Dto;

/**
 * Interface for data transfer transfer object used with the repositories.
 *
 * @package      Prism\Library\Prism\Database
 * @subpackage   Dto
 */
interface CollectionFilters
{
    public function getState(): int;
    public function getLimit(): int;
    public function getOffset(): int;
}
