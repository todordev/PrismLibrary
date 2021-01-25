<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Money;

use Prism\Library\Prism\Domain;

/**
 * This class provides functionality that manage currency collection.
 *
 * @package      Prism
 * @subpackage   Money
 */
final class Currencies extends Domain\Collection
{
    /**
     * Find Currency object by code.
     *
     * @param string $code
     *
     * @return Currency|null
     */
    public function find($code)
    {
        /** @var Currency $item */
        foreach ($this->items as $item) {
            if ($code === $item->getCode()) {
                return $item;
            }
        }

        return null;
    }
}
