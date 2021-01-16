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

interface RowInserter
{
    /**
     * Insert data in database records.
     *
     * @param Registry  $data
     * @param Registry|null  $options
     *
     * @return void
     */
    public function insert(Registry $data, Registry $options = null): void;
}
