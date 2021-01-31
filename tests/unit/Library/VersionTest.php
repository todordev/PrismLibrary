<?php
/**
 * @package        Joomla.UnitTest
 * @subpackage  Version
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Prism\Test\Prism\Unit\Library;

use Prism\Library\Prism\Version;
use Joomla\Tests\Unit\UnitTestCase;

/**
 * Test class for Version.
 *
 * @package     Joomla.UnitTest
 * @subpackage  Version
 * @since       3.0
 */
class VersionTest extends UnitTestCase
{
    /**
     * @var    Version
     * @since  3.0
     */
    protected $version;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     *
     * @since   3.0
     */
    protected function setUp(): void
    {
        $this->version = new Version();
    }

    /**
     * Overrides the parent tearDown method.
     *
     * @return  void
     *
     * @see     \PHPUnit\Framework\TestCase::tearDown()
     * @since   3.6
     */
    protected function tearDown(): void
    {
        unset($this->version);
        parent::tearDown();
    }

    /**
     * Tests the getShortVersion method
     *
     * @return  void
     *
     * @since   3.0
     */
    public function testGetShortVersion()
    {
        $this->assertEquals('2.0', $this->version->getShortVersion());
    }

    /**
     * Tests the getLongVersion method
     *
     * @return  void
     *
     * @since   3.0
     */
    public function testGetLongVersion()
    {
        $this->assertIsString($this->version->getLongVersion());
    }
}
