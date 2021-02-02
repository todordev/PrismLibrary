<?php
/**
 * @package      Prism
 * @subpackage   Intl
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Intl;

/**
 * Parse amounts.
 */
interface Parser
{
    /**
     * Parse an amount.
     *
     * @param string $amount
     * @return float
     */
    public function parse(string $amount): float;
}
