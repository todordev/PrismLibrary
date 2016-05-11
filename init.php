<?php
/**
 * @package      Prism
 * @subpackage   Initialization
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

if (!defined('PRISM_PATH_LIBRARY')) {
    define('PRISM_PATH_LIBRARY', JPATH_LIBRARIES . '/Prism');
}

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.path');

JLoader::registerNamespace('Abraham', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('AdamPaterson', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('Aws', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('Carbon', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('Coinbase', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('Defuse', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('Facebook', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('Google', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('GuzzleHttp', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('JmesPath', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('League', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('Money', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('Monolog', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('Prism', JPATH_LIBRARIES);
JLoader::registerNamespace('Psr', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('RandomLib', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('React', PRISM_PATH_LIBRARY . '/libs');
JLoader::registerNamespace('SecurityLib', PRISM_PATH_LIBRARY . '/libs');

// Register some helpers.
JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');

// Load library language.
$lang = JFactory::getLanguage();
$lang->load('lib_prism', PRISM_PATH_LIBRARY);
