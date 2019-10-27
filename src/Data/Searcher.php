<?php
/**
 * @package      Prism
 * @subpackage   Data
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Data;

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
