<?php
/**
 * @package      Prism
 * @subpackage   Intl
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Intl;

/**
 * Parse amounts.
 */
interface Parser
{
    /**
     * Parse an amount.
     *
     * @param string $amount
     *
     * @return float
     */
    public function parse($amount);
}
