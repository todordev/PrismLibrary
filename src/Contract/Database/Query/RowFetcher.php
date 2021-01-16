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

interface RowFetcher
{
    /**
     * Fetch a row from database.
     *
     * @param int  $id
     * @param Registry|null  $options
     *
     * @return array
     */
    public function fetch(int $id, Registry $options = null): array;
}
