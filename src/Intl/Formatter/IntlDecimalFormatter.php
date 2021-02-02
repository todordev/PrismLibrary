<?php
/**
 * @package      Prism\Library\Prism\Intl\Formatter
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Intl\Formatter;

use Prism\Library\Prism\Intl\Formatter;

/**
 * Formats a number using intl extension.
 *
 * @package Prism\Library\Prism\Intl\Formatter
 */
final class IntlDecimalFormatter implements Formatter
{
    /**
     * @var \NumberFormatter
     */
    private $formatter;

    /**
     * @param \NumberFormatter $formatter
     */
    public function __construct(\NumberFormatter $formatter)
    {
        $this->formatter  = $formatter;
    }

    public function format(float $value): string
    {
        return (string)$this->formatter->format($value);
    }
}
