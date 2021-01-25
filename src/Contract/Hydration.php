<?php
/**
 * @package      Prism\Library\Prism\Contract
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract;

/**
 * Interface Hydration
 *
 * @package Prism\Library\Prism\Contract
 */
interface Hydration
{
    /**
     * Hydrate data to the object properties.
     *
     * @param array $data
     * @param array $ignored List with properties that should be ignored during the process of hydration.
     */
    public function hydrate(array $data, array $ignored = []);
}
