<?php
/**
 * @package      Prism
 * @subpackage   Payment\iDEAL
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('JPATH_PLATFORM') or die;

JLoader::registerNamespace('GuzzleHttp', PRISM_PATH_LIBRARY . '/libs');
JLoader::import('Prism.libs.GuzzleHttp.Promise.functions');
JLoader::import('Prism.libs.GuzzleHttp.Psr7.functions');
JLoader::import('Prism.libs.GuzzleHttp.functions');
