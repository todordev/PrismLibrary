<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Collection;

interface CollectionHydration
{
    /**
     * Hydrate data to the collection.
     *
     * @param array $data
     */
    public function hydrate(array $data): void;
}
