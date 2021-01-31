<?php
/**
 * @package      Prism\Library\Prism
 * @subpackage   Category
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Category;

use Prism\Library\Prism\Contract\Domain;
use Prism\Library\Prism\Contract\Arrayable;
use Prism\Library\Prism\Domain\Identifier\Identifier;
use Prism\Library\Prism\Domain\EntityIdentifier;

/**
 * Category entity.
 *
 * @package      Prism\Library\Prism
 * @subpackage   Category
 */
final class CategoryEntity implements Domain\Entity, Arrayable
{
    use EntityIdentifier;

    private Category $category;

    public function __construct(Identifier $identifier, Category $category)
    {
        $this->identifier = $identifier;
        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function item(): Category
    {
        return $this->category;
    }

    /**
     * Returns an associative array with keys similar to table columns of the entity.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(
            ['id' => $this->identifier->getValue()],
            $this->item()->toArray()
        );
    }
}
