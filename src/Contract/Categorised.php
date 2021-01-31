<?php
/**
 * @package      Prism\Library\Prism\Contract
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract;

use Prism\Library\Prism\Category\Category;

/**
 * Interface of items which are assigned to a category.
 *
 * @package Prism\Library\Prism\Contract
 */
interface Categorised
{
    public function getCategoryId(): int;
    public function category(): Category;
}
