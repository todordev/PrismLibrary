<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
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
