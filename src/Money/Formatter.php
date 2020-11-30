<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Money;

/**
 * Formats amounts.
 */
interface Formatter
{
    /**
     * Formats an amount as decimal string.
     *
     * @param Money $money
     *
     * @return string
     */
    public function format(Money $money);

    /**
     * Formats an amount as currency string.
     *
     * @param Money $money
     *
     * @return string
     */
    public function formatCurrency(Money $money);
}
