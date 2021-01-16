<?php
/**
 * @package      Prism\Library\Fundocs\Item
 * @subpackage   Query
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Database\Query;

use Joomla\Registry\Registry;

interface CollectionFetcher
{
    /**
     * Retrieve collection of items.
     *
     * @param array $ids
     * @param Registry|null $options
     * @return array
     */
    public function fetch(array $ids, Registry $options = null): array;
}
