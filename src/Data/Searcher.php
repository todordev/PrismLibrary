<?php
/**
 * @package      Prism
 * @subpackage   Data
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Data;

/**
 * Interface for classes that should prepare search query.
 *
 * @package      Prism
 * @subpackage   Data
 */
interface Searcher
{
    public function prepareQuery(\JDatabaseQuery $query, array $options = array());
}
