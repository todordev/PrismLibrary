<?php
/**
 * @package      Prism\Library\Prism\Contract
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract;

interface HasSameTypeAs
{
    /**
     * @param mixed $object
     *
     * @return bool
     */
    public function sameTypeAs(mixed $object): bool;
}
