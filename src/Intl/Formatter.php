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
 * Formats amounts.
 */
interface Formatter
{
    /**
     * Formats an amount as decimal string.
     *
     * @param float $value
     * @return string
     */
    public function format(float $value): string;
}
