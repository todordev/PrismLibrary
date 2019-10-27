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
 * Formats amounts.
 */
interface Formatter
{
    /**
     * Formats an amount as decimal string.
     *
     * @param float $value
     *
     * @return string
     */
    public function format($value);
}
