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
use Prism\Library\Prism\Domain\Identifier\Identifier;
use Prism\Library\Prism\Domain\EntityIdentifier;

/**
 * Category entity.
 *
 * @package      Prism\Library\Prism
 * @subpackage   Category
 */
final class Category implements Domain\Entity
{
    use EntityIdentifier;

    private string $title = '';

    public function __construct(Identifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Category
     */
    public function setTitle(string $title): Category
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Returns an associative array with keys similar to table columns of the entity.
     *
     * @return array
     *
     * @since version
     */
    public function toArray(): array
    {
        return [
            'id' => $this->identifier->getValue(),
            'title' => $this->title(),
        ];
    }
}
