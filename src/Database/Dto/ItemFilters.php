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
 * Item filters for repository.
 *
 * @package      Prism\Library\Prism\Database
 * @subpackage   Dto
 */
final class ItemFilters
{
    private int $state;

    public function __construct(int $state)
    {
        $this->state = $state;
    }

    public function getState(): int
    {
        return $this->state;
    }
}
