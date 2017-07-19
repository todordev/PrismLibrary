<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Money\Parser;

use Prism\Money\Parser;

/**
 * Formats a Money object using intl extension.
 *
 * @package      Prism\Money
 * @subpackage   Parsers
 */
final class IntlDecimalParser implements Parser
{
    /**
     * @var \NumberFormatter
     */
    private $parser;

    /**
     * @param \NumberFormatter $parser
     */
    public function __construct(\NumberFormatter $parser)
    {
        $this->parser  = $parser;
    }

    /**
     * Parse decimal value.
     *
     * @param string $amount
     *
     * @return string
     */
    public function parse($amount)
    {
        return $this->parser->parse($amount, \NumberFormatter::TYPE_DOUBLE);
    }
}
