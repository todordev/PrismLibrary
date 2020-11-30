<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Intl\Formatter;

use Prism\Library\Prism\Intl\Formatter;

/**
 * Formats a number using intl extension.
 *
 * @package      Prism\Library\Prism\Money
 * @subpackage   Formatters
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

    /**
     * {@inheritdoc}
     */
    public function format($value)
    {
        return (string)$this->formatter->format($value);
    }
}
