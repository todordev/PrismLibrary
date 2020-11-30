<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Money;

use Prism\Library\Domain\HydratingImmutable;

/**
 * This class contains methods that are used for managing currency.
 *
 * @package      Prism
 * @subpackage   Money
 */
final class Currency implements LegalTender
{
    use HydratingImmutable;

    private const SYMBOL_LEFT = 0;
    private const SYMBOL_RIGHT  = 1;

    private $title;
    private $code;
    private $symbol;
    private $position;

    public function __construct(array $properties = [])
    {
        $this->title      = array_key_exists('title', $properties) ? $properties['title'] : '';
        $this->code       = array_key_exists('code', $properties) ? $properties['code'] : '';
        $this->symbol     = array_key_exists('symbol', $properties) ? $properties['symbol'] : '';
        $this->position   = array_key_exists('position', $properties) ? $properties['position'] : '';
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
     * $currency  = new Prism\Library\Money\Currency($data);
     * echo $currency->getTitle();
     * </code>
     *
     * @return string
     */
    public function getTitle(): string
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
     * $currency  = new Prism\Library\Money\Currency($data);
     * echo $currency->getCode();
     * </code>
     *
     * @return string
     */
    public function getCode(): string
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
     * $currency  = new Prism\Library\Money\Currency($data);
     * echo $currency->getSymbol();
     * </code>
     *
     * @return string
     */
    public function getSymbol(): string
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
     * $currency  = new Prism\Library\Money\Currency($data);
     * if (0 === $currency->getPosition()) {
     * }
     * </code>
     *
     * @return int
     */
    public function getPosition(): int
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
     * $currency  = new Prism\Library\Money\Currency($data);
     * if ($currency->symbolLeft()) {
     * }
     * </code>
     *
     * @return bool
     */
    public function symbolLeft(): bool
    {
        return (self::SYMBOL_LEFT === $this->getPosition());
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
     * $currency  = new Prism\Library\Money\Currency($data);
     * if ($currency->symbolRight()) {
     * }
     * </code>
     *
     * @return bool
     */
    public function symbolRight(): bool
    {
        return (self::SYMBOL_RIGHT === $this->getPosition());
    }

    /**
     * Checks whether this currency is the same as an other.
     *
     * @param LegalTender $other
     *
     * @return bool
     */
    public function equals(LegalTender $other): bool
    {
        return $this->code === $other->getCode();
    }
}
