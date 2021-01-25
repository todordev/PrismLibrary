<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Money;

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
    private $amount;

    /**
     * Currency object.
     *
     * @var Currency
     */
    private $currency;

    /**
     * Initialize the object.
     *
     * <code>
     * $amount = 1,500.25;
     *
     * $currency = new Currency();
     * $money    = new Prism\Library\Prism\Money\Money($amount, $currency);
     * </code>
     *
     * @param mixed       $amount
     * @param LegalTender $currency
     */
    public function __construct($amount, LegalTender $currency)
    {
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    /**
     * Return currency object.
     *
     * <code>
     * $currency = new Currency();
     * $money    = new Prism\Library\Prism\Money\Money($amount, $currency);
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
     * $money    = new Prism\Library\Prism\Money\Money($amount, $currency);
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
     * $currency = new Currency();
     * $money    = new Prism\Library\Prism\Money\Money(1,500.25, $currency);
     *
     * $money2   = $money->setAmount(1,000.00);
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
