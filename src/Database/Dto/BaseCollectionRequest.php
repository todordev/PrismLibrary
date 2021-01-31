<?php
/**
 * @package      Prism\Library\Prism\Database
 * @subpackage   Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database\Dto;

use Prism\Library\Prism\Contract\Database\ColumnsSelector;
use Prism\Library\Prism\Contract\Database\CollectionFilters;
use Prism\Library\Prism\Contract\Database\CollectionRequest;

/**
 * Base request for retrieving collection from repository.
 *
 * @package      Prism\Library\Prism\Database
 * @subpackage   Dto
 */
final class BaseCollectionRequest implements CollectionRequest, ColumnsSelector
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
