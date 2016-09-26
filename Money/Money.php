<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Money;

use Joomla\Registry\Registry;
use Prism\Money\CurrencyInterface;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing an amount.
 *
 * @package      Prism
 * @subpackage   Money
 */
class Money
{
    /**
     * Amount value.
     *
     * @var mixed
     */
    protected $amount;

    /**
     * Currency object.
     *
     * @var CurrencyInterface
     */
    protected $currency;

    /**
     * @var \NumberFormatter
     */
    protected $formatter;

    /**
     * Initialize the object.
     *
     * <code>
     * $amount = 1,500.25;
     *
     * $language         = JFactory::getLanguage();
     * $moneyFormatter   = new NumberFormatter($language->getTag(), NumberFormatter::PATTERN_DECIMAL, $this->params->get('currency_pattern'));
     *
     * $money   = new Prism\Money\Money($moneyFormatter, $amount);
     * </code>
     *
     * @param \NumberFormatter $formatter
     * @param mixed $amount
     */
    public function __construct(\NumberFormatter $formatter, $amount = 0.00)
    {
        $this->amount    = $amount;
        $this->formatter = $formatter;
    }

    /**
     * Set the currency object.
     *
     * <code>
     * $currencyId = 1;
     * $currency   = new Virtualcurrency\Currency\Currency(\JFactory::getDbo());
     * $currency->load($currencyId);
     *
     * $language         = JFactory::getLanguage();
     * $moneyFormatter   = new NumberFormatter($language->getTag(), NumberFormatter::PATTERN_DECIMAL, $this->params->get('currency_pattern'));
     *
     * $money   = new Prism\Money\Money($moneyFormatter);
     * $money->setCurrency($currency);
     * </code>
     *
     * @param CurrencyInterface $currency
     *
     * @return self
     */
    public function setCurrency(CurrencyInterface $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Return currency object.
     *
     * <code>
     * $currencyId = 1;
     * $currency   = new Virtualcurrency\Currency\Currency(\JFactory::getDbo());
     * $currency->load($currencyId);
     *
     * $language         = JFactory::getLanguage();
     * $moneyFormatter   = new NumberFormatter($language->getTag(), NumberFormatter::PATTERN_DECIMAL, $this->params->get('currency_pattern'));
     *
     * $money   = new Prism\Money\Money($moneyFormatter);
     * $money->setCurrency($currency);
     *
     * $currency = $money->getCurrency();
     * </code>
     *
     * @return CurrencyInterface|null
     */
    public function getCurrency()
    {
        return $this->currency;
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
     * $money   = new Prism\Money\Money($moneyFormatter, $amount);
     * $money->setCurrency($currency);
     *
     * // Return $1,500.25 or 1,500.25USD.
     * echo $money->formatCurrency();
     * </code>
     *
     * @return string
     */
    public function formatCurrency()
    {
        $amount = $this->formatter->format($this->amount);

        if ($this->currency->getSymbol()) {
            $amount = $this->currency->getSymbol().$amount;
        } elseif ($this->currency->getCode()) {
            $amount .= ' '. $this->currency->getCode();
        }

        return $amount;
    }

    /**
     * This method returns formatted amount.
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
     * $money   = new Prism\Money\Money($moneyFormatter, $amount);
     * $money->setCurrency($currency);
     *
     * // Return 1,500.25.
     * echo $money->format();
     * </code>
     *
     * @return string
     */
    public function format()
    {
        return $this->formatter->format($this->amount);
    }

    /**
     * Use this method to parse currency string.
     *
     * <code>
     * $amount   = 1,500.25;
     *
     * $language         = JFactory::getLanguage();
     * $moneyFormatter   = new NumberFormatter($language->getTag(), NumberFormatter::PATTERN_DECIMAL, $this->params->get('currency_pattern'));
     *
     * $money   = new Prism\Money\Money($moneyFormatter);
     * $money->setValue($amount);
     *
     * // Will return 1500.25.
     * $goal = $money->parse();
     * </code>
     *
     * @return string
     */
    public function parse()
    {
        return $this->formatter->parse($this->amount, \NumberFormatter::TYPE_DOUBLE);
    }

    /**
     * Set the amount value.
     *
     * <code>
     * $amount   = 1,500.25;
     *
     * $language         = JFactory::getLanguage();
     * $moneyFormatter   = new NumberFormatter($language->getTag(), NumberFormatter::PATTERN_DECIMAL, $this->params->get('currency_pattern'));
     *
     * $money   = new Prism\Money\Money($moneyFormatter);
     * $money->setValue($amount);
     * </code>
     *
     * @param float $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }
}
