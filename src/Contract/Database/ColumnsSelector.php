<?php
/**
 * @package   Prism\Library\Prism\Contract\Database
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Database;

/**
 * Add functionality to choice columns when select data.
 *
 * @package Prism\Library\Prism\Contract\Database
 */
interface ColumnsSelector
{
    public function getColumns(): array;
}
