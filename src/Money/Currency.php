<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
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

    public const SYMBOL_LEFT = 0;
    public const SYMBOL_RIGHT = 1;

    private $name;
    private $code;
    private $symbol;
    private $position;

    public function __construct(array $properties = [])
    {
        $this->name = array_key_exists('name', $properties) ? $properties['name'] : '';
        $this->code = array_key_exists('code', $properties) ? $properties['code'] : '';
        $this->symbol = array_key_exists('symbol', $properties) ? $properties['symbol'] : '';
        $this->position = array_key_exists('position', $properties) ? $properties['position'] : '';
    }

    /**
     * Return currency name.
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
     * echo $currency->getName();
     * </code>
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
