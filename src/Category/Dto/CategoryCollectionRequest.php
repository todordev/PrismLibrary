<?php
/**
 * @package      Prism\Library\Prism\Category
 * @subpackage   Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Category\Dto;

use Prism\Library\Prism\Contract\Database\ColumnsSelector;
use Prism\Library\Prism\Contract\Database\CollectionRequest;
use Prism\Library\Prism\Contract\Database\CollectionFilters;

/**
 * Request to a repository to fetch collection of categories.
 *
 * @package      Prism\Library\Prism\Category
 * @subpackage   Dto
 */
final class CategoryCollectionRequest implements CollectionRequest, ColumnsSelector
{
    private array $identifiers;
    private array $columns;
    private ?CollectionFilters $filters;

    public function __construct(
        array $identifiers,
        array $columns = [],
        CollectionFilters $filters = null
    ) {

        $this->identifiers = $identifiers;
        $this->columns = $columns;
        $this->filters = $filters;
    }

    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getFilters(): ?CollectionFilters
    {
        return $this->filters;
    }
}
