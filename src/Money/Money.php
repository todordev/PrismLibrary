<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Money;

/**
 * This class contains methods that are used for managing an amount.
 *
 * @package      Prism
 * @subpackage   Money
 */
final class Money
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
     * @var Currency
     */
    protected $currency;

    /**
     * Initialize the object.
     *
     * <code>
     * $amount = 1,500.25;
     *
     * $language = JFactory::getLanguage();
     * $currency = new Currency();
     *
     * $money    = new Prism\Money\Money($amount, $currency);
     * </code>
     *
     * @param mixed    $amount
     * @param Currency $currency
     */
    public function __construct($amount, Currency $currency)
    {
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    /**
     * Return currency object.
     *
     * <code>
     * $currency = new Currency();
     *
     * $money   = new Prism\Money\Money($moneyFormatter);
     * $money->setCurrency($currency);
     *
     * $currency = $money->getCurrency();
     * </code>
     *
     * @return Currency|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Get the amount value.
     *
     * <code>
     * $amount   = 1,500.25;
     *
     * $currency = new Currency();
     * $money    = new Prism\Money\Money($amount, $currency);
     *
     * echo $money->getAmount();
     * </code>
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set an amount returning a new Money object because it is immutable.
     *
     * <code>
     * $amount   = 1,500.25;
     *
     * $currency = new Currency();
     * $money    = new Prism\Money\Money(0.00, $currency);
     *
     * $money2   = $money->setAmount($amount);
     * </code>
     *
     * @param float $amount
     *
     * @return Money
     */
    public function setAmount($amount)
    {
        return new self($amount, $this->currency);
    }

    /**
     * Checks whether a Money has the same Currency as this.
     *
     * @param Money $other
     *
     * @return bool
     */
    public function isSameCurrency(Money $other)
    {
        return $this->currency->equals($other->getCurrency());
    }

    /**
     * Checks whether the value represented by this object equals to the other.
     *
     * @param Money $other
     *
     * @return bool
     */
    public function equals(Money $other)
    {
        return ($this->isSameCurrency($other) && $this->getAmount() === $other->getAmount());
    }
}
