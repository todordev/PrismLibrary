<?php
/**
 * @package     Prism\UnitTest
 * @subpackage  Money
 * @author      Todor Iliev
 * @copyright   Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

use Joomla\Tests\Unit\UnitTestCase;
use Prism\Library\Prism\Money\Money;
use Prism\Library\Prism\Money\Currency;

/**
 * Test class for Prism\UnitTest.
 *
 * @package     Prism\UnitTest
 * @subpackage  Money
 */
class MoneyTest extends UnitTestCase
{
    /**
     * @var    Money
     */
    protected $money;

    /**
     * @var    Currency
     */
    protected $currency;

    /**
     * Test the getAmount method.
     *
     * @return  void
     * @covers  Money::getAmount
     */
    public function testGetAmount(): void
    {
        $this->assertEquals(10.20, $this->money->getAmount());
    }

    /**
     * Test the getCurrency method.
     *
     * @return  void
     * @covers  Money::getCurrency
     */
    public function testGetCurrency(): void
    {
        $this->assertEquals($this->currency, $this->money->getCurrency());
    }

    /**
     * Test the setAmount method.
     *
     * @return  void
     * @covers  Money::setAmount
     */
    public function testSetAmount(): void
    {
        $money = $this->money->setAmount(200);

        $this->assertEquals(200, $money->getAmount());
    }

    /**
     * Test the isSameCurrency method.
     *
     * @return  void
     * @covers  Money::isSameCurrency
     * @throws  Prism\Library\Prism\Domain\HydrationException
     */
    public function testIsSameCurrency(): void
    {
        $currency = new Currency();
        $currency->hydrate(
            [
                'title' => 'American Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'position' => '0',
            ]
        );

        $other = new Money(100, $currency);

        $this->assertFalse($this->money->isSameCurrency($other));
    }

    /**
     * Test the equals method.
     *
     * @return  void
     * @covers  Money::equals
     */
    public function testEquals(): void
    {
        $money = $this->money->setAmount(200);

        $this->assertFalse($this->money->equals($money));
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     * @throws  Prism\Library\Prism\Domain\HydrationException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $jsonData = file_get_contents(PATH_PRISM_LIBRARY_TESTS_DATA . '/currency.json');
        $data = json_decode($jsonData, true);

        $this->currency = new Currency();
        $this->currency->hydrate($data);

        $this->money = new Money(10.20, $this->currency);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     * @see     TestCase::tearDown()
     */
    protected function tearDown(): void
    {
        unset($this->money, $this->currency);
        parent::tearDown();
    }
}
