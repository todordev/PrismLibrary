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

JLoader::register('Psr\\Http\\Message\\MessageInterface', PRISM_PATH_LIBRARY . '/libs/Psr/Http/MessageInterface.php');
JLoader::register('Psr\\Http\\Message\\RequestInterface', PRISM_PATH_LIBRARY . '/libs/Psr/Http/RequestInterface.php');
JLoader::register('Psr\\Http\\Message\\ResponseInterface', PRISM_PATH_LIBRARY . '/libs/Psr/Http/ResponseInterface.php');
JLoader::register('Psr\\Http\\Message\\ServerRequestInterface', PRISM_PATH_LIBRARY . '/libs/Psr/Http/ServerRequestInterface.php');
JLoader::register('Psr\\Http\\Message\\StreamInterface', PRISM_PATH_LIBRARY . '/libs/Psr/Http/StreamInterface.php');
JLoader::register('Psr\\Http\\Message\\UploadedFileInterface', PRISM_PATH_LIBRARY . '/libs/Psr/Http/UploadedFileInterface.php');
JLoader::register('Psr\\Http\\Message\\UriInterface', PRISM_PATH_LIBRARY . '/libs/Psr/Http/UriInterface.php');
