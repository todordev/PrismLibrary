<?php
/**
 * @package     Prism\UnitTest
 * @subpackage  Money
 * @author      Todor Iliev
 * @copyright   Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

use Prism\Money\Currency;

/**
 * Test class for Prism\UnitTest.
 *
 * @package     Prism\UnitTest
 * @subpackage  Money
 */
class CurrencyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    Currency
     */
    protected $object;

    /**
     * Test the getTitle method.
     *
     * @return  void
     * @covers  Currency::getTitle
     */
    public function testGetTitle()
    {
        $this->assertEquals(
            'EURO',
            $this->object->getTitle()
        );
    }

    /**
     * Test the getCode method.
     *
     * @return  void
     * @covers  Currency::getCode
     */
    public function testGetCode()
    {
        $this->assertEquals(
            'EUR',
            $this->object->getCode()
        );
    }

    /**
     * Test the getSymbol method.
     *
     * @return  void
     * @covers  Currency::getSymbol
     */
    public function testGetSymbol()
    {
        $this->assertEquals(
            '€',
            $this->object->getSymbol()
        );
    }

    /**
     * Test the getPosition method.
     *
     * @return  void
     * @covers  Currency::getPosition
     */
    public function testGetPosition()
    {
        $this->assertEquals(
            Currency::SYMBOL_BEFORE,
            $this->object->getPosition()
        );
    }

    /**
     * Test the symbolBefore method.
     *
     * @return  void
     * @covers  Currency::symbolBefore
     */
    public function testSymbolBefore()
    {
        $this->assertTrue($this->object->symbolBefore());
    }

    /**
     * Test the symbolAfter method.
     *
     * @return  void
     * @covers  Currency::symbolAfter
     */
    public function testSymbolAfter()
    {
        $this->assertFalse($this->object->symbolAfter());
    }

    /**
     * Test the equals method.
     *
     * @return  void
     * @covers  Currency::equals
     */
    public function testEquals()
    {
        $currency = new Currency();
        $currency->bind([
            'title' => 'American Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'position' => '0',
        ]);

        $this->assertFalse($this->object->equals($currency));
    }

    /**
     * Test the symbolBefore method.
     *
     * @return  void
     * @covers  Currency::bind
     *
     * @expectedException Prism\Domain\BindException
     */
    public function testBindException()
    {
        $data = array(
            'code' => 'USD'
        );

        $this->object->bind($data);
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

        $this->object = new Currency();
        $this->object->bind($data);
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
        unset($this->object);
        parent::tearDown();
    }
}
