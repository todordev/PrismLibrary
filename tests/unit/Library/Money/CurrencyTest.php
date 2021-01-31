<?php
/**
 * @package     Prism\UnitTest
 * @subpackage  Money
 * @author      Todor Iliev
 * @copyright   Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

use Joomla\Tests\Unit\UnitTestCase;
use Prism\Library\Prism\Money\Currency;

/**
 * Test class for Prism\UnitTest.
 *
 * @package     Prism\UnitTest
 * @subpackage  Money
 */
class CurrencyTest extends UnitTestCase
{
    /**
     * @var    Currency
     */
    protected $object;

    /**
     * Test the getTitle method.
     *
     * @return  void
     * @covers  Currency::getName
     */
    public function testGetName()
    {
        $this->assertEquals(
            'EURO',
            $this->object->getName()
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
            Currency::SYMBOL_LEFT,
            $this->object->getPosition()
        );
    }

    /**
     * Test the symbolBefore method.
     *
     * @return  void
     * @covers  Currency::symbolLeft
     */
    public function testSymbolLeft()
    {
        $this->assertTrue($this->object->symbolLeft());
    }

    /**
     * Test the symbolAfter method.
     *
     * @return  void
     * @covers  Currency::symbolRight
     */
    public function testSymbolRight()
    {
        $this->assertFalse($this->object->symbolRight());
    }

    /**
     * Test the equals method.
     *
     * @return  void
     * @covers  Currency::equals
     * @throws  Prism\Library\Prism\Domain\HydrationException
     */
    public function testEquals()
    {
        $currency = new Currency();
        $currency->hydrate(
            [
                'name' => 'American Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'position' => '0',
            ]
        );

        $this->assertFalse($this->object->equals($currency));
    }

    /**
     * Test the symbolBefore method.
     *
     * @return  void
     * @covers  Currency::hydrate
     */
    public function testBindException()
    {
        $data = [
            'code' => 'USD'
        ];

        $this->expectException(Prism\Library\Prism\Domain\HydrationException::class);
        $this->object->hydrate($data);
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

        $this->object = new Currency();
        $this->object->hydrate($data);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     * @see     PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown(): void
    {
        unset($this->object);
        parent::tearDown();
    }
}
