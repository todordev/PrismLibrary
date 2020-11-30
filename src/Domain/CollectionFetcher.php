<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Domain;

use Prism\Library\Database\Request\Request;

/**
 * Interface CollectionFetcher
 * @package Prism\Library\Domain
 * @deprecated
 */
interface CollectionFetcher
{
    /**
     * @param Request $request
     *
     * @return Collection
     */
    public function fetchCollection(Request $request);
}
