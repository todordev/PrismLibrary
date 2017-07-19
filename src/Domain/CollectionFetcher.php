<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Domain;

interface CollectionFetcher
{
    /**
     * @param array $conditions
     *
     * @return Collection
     */
    public function fetchCollection(array $conditions = array());
}
