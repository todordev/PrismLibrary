<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Money\Parser;

use Prism\Library\Prism\Money\Parser;

/**
 * Formats a Money object using intl extension.
 *
 * @package      Prism\Library\Prism\Money
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
