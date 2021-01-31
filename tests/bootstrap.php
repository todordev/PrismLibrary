<?php
/**
 * Prepares a minimalist framework for unit testing.
 *
 * @package    Joomla.UnitTest
 *
 * @copyright  Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://www.phpunit.de/manual/current/en/installation.html
 */

$packageFolder = '/pkg_prism';
$rootDirectory = substr(getcwd(), 0, (-1 * strlen($packageFolder)));

if (!defined('JPATH_BASE')) {
    define('JPATH_BASE', $rootDirectory);
}

// Load Joomla! tests bootstrap.
require_once JPATH_BASE . '/tests/Unit/bootstrap.php';

define('PATH_PRISM_LIBRARY_TESTS', JPATH_ROOT . $packageFolder . '/tests');
define('PATH_PRISM_LIBRARY_TESTS_DATA', PATH_PRISM_LIBRARY_TESTS . '/Unit/data');

JLoader::registerNamespace('\\Prism\\Library\\Prism', JPATH_ROOT . '/libraries/Prism', false, false, 'psr4');
JLoader::registerNamespace('\\Prism\\Test\\Prism', PATH_PRISM_LIBRARY_TESTS, false, false, 'psr4');
