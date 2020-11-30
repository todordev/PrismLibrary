<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Domain;

/**
 * Interface CollectionHydration
 * @package Prism\Library\Domain
 * @deprecated
 */
interface CollectionHydration
{
    /**
     * Hydrate data to the collection.
     *
     * @param array $data
     */
    public function hydrate(array $data): void;
}
