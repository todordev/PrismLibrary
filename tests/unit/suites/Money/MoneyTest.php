<?php
/**
 * @package     Prism\UnitTest
 * @subpackage  Money
 * @author      Todor Iliev
 * @copyright   Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

use Prism\Money\Money;
use Prism\Money\Currency;

/**
 * Test class for Prism\UnitTest.
 *
 * @package     Prism\UnitTest
 * @subpackage  Money
 */
class MoneyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    Money
     */
    protected $object;

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
    public function testGetAmount()
    {
        $this->assertEquals(
            10.20,
            $this->object->getAmount()
        );
    }

    /**
     * Test the getCurrency method.
     *
     * @return  void
     * @covers  Money::getCurrency
     */
    public function testGetCurrency()
    {
        $this->assertEquals(
            $this->currency,
            $this->object->getCurrency()
        );
    }

    /**
     * Test the setAmount method.
     *
     * @return  void
     * @covers  Money::setAmount
     */
    public function testSetAmount()
    {
        $money = $this->object->setAmount(200);

        $this->assertEquals(
            200,
            $money->getAmount()
        );
    }

    /**
     * Test the isSameCurrency method.
     *
     * @return  void
     * @covers  Money::isSameCurrency
     */
    public function testIsSameCurrency()
    {
        $currency = new Currency();
        $currency->bind([
            'title' => 'American Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'position' => '0',
        ]);

        $other = new Money(100, $currency);

        $this->assertFalse($this->object->isSameCurrency($other));
    }

    /**
     * Test the equals method.
     *
     * @return  void
     * @covers  Money::equals
     */
    public function testEquals()
    {
        $money = $this->object->setAmount(200);

        $this->assertFalse($this->object->equals($money));
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     */
    protected function setUp()
    {
        parent::setUp();

        $jsonData = file_get_contents(PRISM_TESTS_FOLDER_STUBS_DATA.'currency.json');
        $data     = json_decode($jsonData, true);

        $this->currency = new Currency();
        $this->currency->bind($data);

        $this->object = new Money(10.20, $this->currency);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     *
     * @see     PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
        unset($this->object, $this->currency);
        parent::tearDown();
    }
}
