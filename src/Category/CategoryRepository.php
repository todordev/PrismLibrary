<?php
/**
 * @package      Prism\Library\Prism
 * @subpackage   Category
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Category;

use Illuminate\Support\Collection;
use Prism\Library\Prism\Database\Dto\ItemByIdRequest;
use Prism\Library\Prism\Category\Mapper\CategoryMapper;
use Prism\Library\Prism\Category\Dto\CategoryCollectionRequest;

/**
 * Repository of Category entities.
 *
 * @package      Prism\Library\Prism
 * @subpackage   Category
 */
final class CategoryRepository
{
    /**
     * @var CategoryMapper
     */
    private CategoryMapper $mapper;

    public function __construct(CategoryMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param ItemByIdRequest $request
     * @return Category|null
     */
    public function fetchById(ItemByIdRequest $request): ?Category
    {
        return $this->mapper->fetchById($request);
    }

    /**
     * @param CategoryCollectionRequest $request
     * @return Collection
     */
    public function fetchCollection(CategoryCollectionRequest $request): Collection
    {
        return $this->mapper->fetchCollection($request);
    }
}
