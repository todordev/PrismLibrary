<?php
/**
 * @package      Prism
 * @subpackage   Initialization
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

if (!defined('PRISM_PATH_LIBRARY')) {
    define('PRISM_PATH_LIBRARY', JPATH_LIBRARIES . '/Prism');
}

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.path');

JLoader::registerNamespace('Prism', JPATH_LIBRARIES);

// Register some helpers.
JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');

// Load library language.
$lang = JFactory::getLanguage();
$lang->load('lib_prism', PRISM_PATH_LIBRARY);
