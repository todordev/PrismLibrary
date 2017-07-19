<?php
/**
 * @package      Prism
 * @subpackage   Data
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Data;

/**
 * Interface for classes that should provide functionality for fonding data.
 *
 * @package      Prism
 * @subpackage   Data
 */
interface Finder
{
    public function setSearcher(Searcher $searcher);
}
