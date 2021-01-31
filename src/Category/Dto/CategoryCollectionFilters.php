<?php
/**
 * @package      Prism\Library\Prism\Category
 * @subpackage   Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Category\Dto;

use Prism\Library\Prism\Contract\Database\CollectionFilters;

/**
 * Request filters used to fetch collection of categories by a repository.
 *
 * @package      Prism\Library\Prism\Category
 * @subpackage   Dto
 */
final class CategoryCollectionFilters implements CollectionFilters
{
    private int $state;
    private int $limit;
    private int $offset;
    private array $extensions;

    public function __construct(int $state, int $limit = 0, int $offset = 0, array $extensions = [])
    {
        $this->state = $state;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->extensions = $extensions;
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

    public function getExtensions(): array
    {
        return $this->extensions;
    }
}
