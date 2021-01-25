<?php
/**
 * @package      Prism\Library\Prism\Category
 * @subpackage   Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Category\Dto;

/**
 * Request to a repository to fetch collection of categories.
 *
 * @package      Prism\Library\Prism\Category
 * @subpackage   Dto
 */
final class CategoryCollectionRequest
{
    private array $identifiers;
    private array $columns;
    private ?CategoryCollectionFilters $filters;

    public function __construct(
        array $identifiers,
        array $columns = [],
        CategoryCollectionFilters $filters = null
    ) {

        $this->identifiers = $identifiers;
        $this->columns = $columns;
        $this->filters = $filters;
    }

    public function identifiers(): array
    {
        return $this->identifiers;
    }

    public function columns(): array
    {
        return $this->columns;
    }

    public function filters(): ?CategoryCollectionFilters
    {
        return $this->filters;
    }
}
