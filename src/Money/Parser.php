<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Money;

/**
 * Parse amounts.
 */
interface Parser
{
    /**
     * Parse an amount from decimal string.
     *
     * @param string $amount
     *
     * @return string
     */
    public function parse($amount);
}
