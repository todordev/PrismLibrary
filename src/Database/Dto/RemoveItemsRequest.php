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
 * Request to a repository to remove an item.
 *
 * @package  Prism\Library\Prism\Database\Dto
 * @todo under construction
 */
final class RemoveItemsRequest
{
    private Conditions $conditions;

    public function __construct(Conditions $conditions = null)
    {
        $this->conditions = $conditions;
    }

    public function getConditions(): Conditions
    {
        return $this->conditions;
    }
}
