<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Intl\Formatter;

use Prism\Intl\Formatter;

/**
 * Formats a number using intl extension.
 *
 * @package      Prism\Money
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
