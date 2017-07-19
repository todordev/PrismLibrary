<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Money;

use Prism\Domain\PopulatorImmutable;

/**
 * This class contains methods that are used for managing currency.
 *
 * @package      Prism
 * @subpackage   Money
 */
final class Currency
{
    use PopulatorImmutable;

    const SYMBOL_BEFORE = 0;
    const SYMBOL_AFTER = 1;

    protected $title;
    protected $code;
    protected $symbol;
    protected $position;

    public function __construct(array $properties = array())
    {
        $this->title    = array_key_exists('title', $properties) ? $properties['title'] : '';
        $this->code     = array_key_exists('code', $properties) ? $properties['code'] : '';
        $this->symbol   = array_key_exists('symbol', $properties) ? $properties['symbol'] : '';
        $this->position = array_key_exists('position', $properties) ? $properties['position'] : '';
    }

    /**
     * Return currency title.
     *
     * <code>
     * $data = array(
     *     'title'    => 'EURO',
     *     'code'     => 'EUR',
     *     'symbol'   => '€',
     *     'position' => '0'
     * );
     *
     * $currency  = new Prism\Money\Currency();
     * $currency->bind($data);
     *
     * echo $currency->getTitle();
     * </code>
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Return currency code (abbreviation).
     *
     * <code>
     * $data = array(
     *     'title'    => 'EURO',
     *     'code'     => 'EUR',
     *     'symbol'   => '€',
     *     'position' => '0'
     * );
     *
     * $currency  = new Prism\Money\Currency();
     * $currency->bind($data);
     *
     * echo $currency->getCode();
     * </code>
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Return currency symbol.
     *
     * <code>
     * $data = array(
     *     'title'    => 'EURO',
     *     'code'     => 'EUR',
     *     'symbol'   => '€',
     *     'position' => '0'
     * );
     *
     * $currency  = new Prism\Money\Currency();
     * $currency->bind($data);
     *
     * echo $currency->getSymbol();
     * </code>
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Return the position of currency symbol.
     *
     * <code>
     * $data = array(
     *     'title'    => 'EURO',
     *     'code'     => 'EUR',
     *     'symbol'   => '€',
     *     'position' => '0'
     * );
     *
     * $currency  = new Prism\Money\Currency();
     * $currency->bind($data);
     *
     * // Return 0 = beginning; 1 = end;
     * if (0 === $currency->getPosition()) {
     * ...
     * }
     * </code>
     *
     * @return int
     */
    public function getPosition()
    {
        return (int)$this->position;
    }

    /**
     * Check if currency symbol should stay at the beginning of the formatted amount string.
     *
     * <code>
     * $data = array(
     *     'title'    => 'EURO',
     *     'code'     => 'EUR',
     *     'symbol'   => '€',
     *     'position' => '0'
     * );
     *
     * $currency  = new Prism\Money\Currency();
     * $currency->bind($data);
     *
     * // Return 0 = beginning; 1 = end;
     * if ($currency->symbolBefore()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function symbolBefore()
    {
        return (bool)(self::SYMBOL_BEFORE === $this->getPosition());
    }

    /**
     * Check if currency symbol should stay at the end of the formatted amount string.
     *
     * <code>
     * $data = array(
     *     'title'    => 'EURO',
     *     'code'     => 'EUR',
     *     'symbol'   => '€',
     *     'position' => '0'
     * );
     *
     * $currency  = new Prism\Money\Currency();
     * $currency->bind($data);
     *
     * // Return 0 = beginning; 1 = end;
     * if ($currency->symbolAfter()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function symbolAfter()
    {
        return (bool)(self::SYMBOL_AFTER === $this->getPosition());
    }

    /**
     * Checks whether this currency is the same as an other.
     *
     * @param Currency $other
     *
     * @return bool
     */
    public function equals(Currency $other)
    {
        return $this->code === $other->code;
    }
}
