<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Money\Formatter;

use Prism\Library\Prism\Constants;
use Prism\Library\Prism\Money\Money;
use Prism\Library\Prism\Money\Formatter;

/**
 * Formats a Money object using intl extension.
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
    public function format(Money $money)
    {
        return $this->formatter->format($money->getAmount());
    }

    /**
     * This method returns an amount as currency including symbol or currency code.
     *
     * <code>
     * // Create currency object.
     * $currencyId = 1;
     * $amount     = 1500.25;
     *
     * $realCurrency     = new Virtualcurrency\Currency\RealCurrency(\JFactory::getDbo());
     * $realCurrency->load($currencyId);
     *
     * $language         = JFactory::getLanguage();
     * $moneyFormatter   = new NumberFormatter($language->getTag(), NumberFormatter::PATTERN_DECIMAL, $this->params->get('currency_pattern'));
     *
     * $money   = new Prism\Library\Prism\Money\Money($moneyFormatter, $amount);
     * $money->setCurrency($currency);
     *
     * // Return $1,500.25 or 1,500.25USD.
     * echo $money->formatCurrency();
     * </code>
     *
     * @param Money $money
     *
     * @return string
     */
    public function formatCurrency(Money $money)
    {
        $amount   = $this->formatter->format($money->getAmount());
        $currency = $money->getCurrency();

        if ($currency !== null) {
            if ($currency->getSymbol()) {
                if ($currency->getPosition() === Constants::RIGHT) {
                    $amount .= ' ' . $currency->getSymbol();
                } else {
                    $amount = $currency->getSymbol() . ' ' . $amount;
                }

            } elseif ($currency->getCode()) {
                $amount .= ' '. $currency->getCode();
            }
        }

        return $amount;
    }
}
