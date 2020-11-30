<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

use Prism\Library\Prism\Database\Request\Request;

/**
 * Interface CollectionFetcher
 * @package Prism\Library\Prism\Domain
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
