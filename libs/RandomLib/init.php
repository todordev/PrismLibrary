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

JLoader::register('RandomLib\\Mixer\\Hash', PRISM_PATH_LIBRARY . '/libs/RandomLib/Mixer/Hash.php');
JLoader::register('RandomLib\\Source\\CAPICOM', PRISM_PATH_LIBRARY . '/libs/RandomLib/Source/CAPICOM.php');
JLoader::register('RandomLib\\Source\\MicroTime', PRISM_PATH_LIBRARY . '/libs/RandomLib/Source/MicroTime.php');
JLoader::register('RandomLib\\Source\\MTRand', PRISM_PATH_LIBRARY . '/libs/RandomLib/Source/MTRand.php');
JLoader::register('RandomLib\\Source\\OpenSSL', PRISM_PATH_LIBRARY . '/libs/RandomLib/Source/OpenSSL.php');
JLoader::register('RandomLib\\Source\\Rand', PRISM_PATH_LIBRARY . '/libs/RandomLib/Source/Rand.php');
JLoader::register('RandomLib\\Source\\Random', PRISM_PATH_LIBRARY . '/libs/RandomLib/Source/Random.php');
JLoader::register('RandomLib\\Source\\UniqID', PRISM_PATH_LIBRARY . '/libs/RandomLib/Source/UniqID.php');
JLoader::register('RandomLib\\Source\\URandom', PRISM_PATH_LIBRARY . '/libs/RandomLib/Source/URandom.php');

JLoader::register('RandomLib\\AbstractMixer', PRISM_PATH_LIBRARY . '/libs/RandomLib/AbstractMixer.php');
JLoader::register('RandomLib\\Factory', PRISM_PATH_LIBRARY . '/libs/RandomLib/Factory.php');
JLoader::register('RandomLib\\Generator', PRISM_PATH_LIBRARY . '/libs/RandomLib/Generator.php');
JLoader::register('RandomLib\\Mixer', PRISM_PATH_LIBRARY . '/libs/RandomLib/Mixer.php');
JLoader::register('RandomLib\\Source', PRISM_PATH_LIBRARY . '/libs/RandomLib/Source.php');
