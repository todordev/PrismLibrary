<?php
/**
 * @package      Prism
 * @subpackage   Payment\iDEAL
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('JPATH_PLATFORM') or die;

JLoader::register('SecurityLib\\BigMath\\BCMath', PRISM_PATH_LIBRARY . '/libs/SecurityLib/BigMath/BCMath.php');
JLoader::register('SecurityLib\\BigMath\\GMP', PRISM_PATH_LIBRARY . '/libs/SecurityLib/BigMath/GMP.php');
JLoader::register('SecurityLib\\BigMath\\PHPMath', PRISM_PATH_LIBRARY . '/libs/SecurityLib/BigMath/PHPMath.php');
JLoader::register('SecurityLib\\AbstractFactory', PRISM_PATH_LIBRARY . '/libs/SecurityLib/AbstractFactory.php');
JLoader::register('SecurityLib\\BaseConverter', PRISM_PATH_LIBRARY . '/libs/SecurityLib/BaseConverter.php');
JLoader::register('SecurityLib\\BigMath', PRISM_PATH_LIBRARY . '/libs/SecurityLib/BigMath.php');
JLoader::register('SecurityLib\\Enum', PRISM_PATH_LIBRARY . '/libs/SecurityLib/Enum.php');
JLoader::register('SecurityLib\\Hash', PRISM_PATH_LIBRARY . '/libs/SecurityLib/Hash.php');
JLoader::register('SecurityLib\\Strength', PRISM_PATH_LIBRARY . '/libs/SecurityLib/Strength.php');
