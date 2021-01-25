<?php
/**
 * @package      Prism\Library\Prism\Database
 * @subpackage   Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database\Dto;

use Prism\Library\Prism\Domain\Identifier\Identifier;

/**
 * Requst to a repository to fetch an item by identifier.
 *
 * @package      Prism\Library\Prism\Database
 * @subpackage   Dto
 */
final class ItemByIdRequest implements ItemRequest
{
    private Identifier $identifier;
    private array $columns;
    private ?ItemFilters $filters;

    public function __construct(Identifier $identifier, array $columns = [], ItemFilters $filters = null)
    {
        $this->identifier = $identifier;
        $this->columns = $columns;
        $this->filters = $filters;
    }

    public function getIdentifier(): Identifier
    {
        return $this->identifier;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getFilters(): ?ItemFilters
    {
        return $this->filters;
    }
}
