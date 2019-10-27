<?php
/**
 * @package      Prism
 * @subpackage   Initialization
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

if (!defined('PRISM_PATH_LIBRARY')) {
    define('PRISM_PATH_LIBRARY', JPATH_LIBRARIES . '/Prism');
}

if (!defined('PRISM_PATH_UI_LAYOUTS')) {
    define('PRISM_PATH_UI_LAYOUTS', PRISM_PATH_LIBRARY . '/Ui/layouts');
}

JLoader::registerNamespace('\\Prism\\Library', PRISM_PATH_LIBRARY, false, false, 'psr4');

require_once PRISM_PATH_LIBRARY . '/vendor/autoload.php';
