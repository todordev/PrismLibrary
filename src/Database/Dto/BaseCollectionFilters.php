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
 * Base request filters for retrieving collection from a repository.
 *
 * @package      Prism\Library\Prism\Database
 * @subpackage   Dto
 */
final class BaseCollectionFilters implements CollectionFilters
{
    private int $state;
    private int $limit;
    private int $offset;

    public function __construct(int $state, int $limit = 0, int $offset = 0)
    {
        $this->state = $state;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
