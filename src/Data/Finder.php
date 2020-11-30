<?php
/**
 * @package      Prism
 * @subpackage   Data
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Data;

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
