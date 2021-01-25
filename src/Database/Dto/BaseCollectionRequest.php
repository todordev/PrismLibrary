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
 * Base request for retrieving collection from repository.
 *
 * @package      Prism\Library\Prism\Database
 * @subpackage   Dto
 */
final class BaseCollectionRequest implements CollectionRequest
{
    private array $identifiers;
    private array $columns;
    private ?BaseCollectionFilters $filters;

    public function __construct(
        array $identifiers,
        array $columns = [],
        BaseCollectionFilters $filters = null
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

    public function getFilters(): ?BaseCollectionFilters
    {
        return $this->filters;
    }
}
