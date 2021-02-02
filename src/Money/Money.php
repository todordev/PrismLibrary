<?php
/**
 * @package      Prism\Library\Prism\Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Money;

/**
 * This class contains methods that are used for managing an amount.
 *
 * @package Prism\Library\Prism\Money
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
     * @var LegalTender
     */
    private LegalTender $currency;

    /**
     * Initialize the object.
     * <code>
     * $amount = 1,500.25;
     * $currency = new Currency();
     * $money    = new Prism\Library\Prism\Money\Money($amount, $currency);
     * </code>
     *
     * @param string|int|float $amount
     * @param LegalTender $currency
     */
    public function __construct(string | int | float $amount, LegalTender $currency)
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
     * @return LegalTender
     */
    public function getCurrency(): LegalTender
    {
        return $this->currency;
    }

    /**
     * Get the amount value.
     * <code>
     * $amount   = 1,500.25;
     * $currency = new Currency();
     * $money    = new Prism\Library\Prism\Money\Money($amount, $currency);
     * echo $money->getAmount();
     * </code>
     *
     * @return float|int|string
     */
    public function getAmount(): float | int | string
    {
        return $this->amount;
    }

    /**
     * Checks whether a Money has the same Currency as this.
     *
     * @param Money $other
     *
     * @return bool
     */
    public function equalCurrency(Money $other): bool
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
    public function equal(Money $other): bool
    {
        return ($this->equalCurrency($other) && $this->getAmount() === $other->getAmount());
    }
}
