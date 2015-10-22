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

JLoader::register('League\\Flysystem\\AdapterInterface', PRISM_PATH_LIBRARY . '/libs/Flysystem/AdapterInterface.php');
JLoader::register('League\\Flysystem\\Config', PRISM_PATH_LIBRARY . '/libs/Flysystem/Config.php');
JLoader::register('League\\Flysystem\\ConfigAwareTrait', PRISM_PATH_LIBRARY . '/libs/Flysystem/ConfigAwareTrait.php');
JLoader::register('League\\Flysystem\\Directory', PRISM_PATH_LIBRARY . '/libs/Flysystem/Directory.php');
JLoader::register('League\\Flysystem\\Exception', PRISM_PATH_LIBRARY . '/libs/Flysystem/Exception.php');
JLoader::register('League\\Flysystem\\File', PRISM_PATH_LIBRARY . '/libs/Flysystem/File.php');
JLoader::register('League\\Flysystem\\FileExistsException', PRISM_PATH_LIBRARY . '/libs/Flysystem/FileExistsException.php');
JLoader::register('League\\Flysystem\\FileNotFoundException', PRISM_PATH_LIBRARY . '/libs/Flysystem/FileNotFoundException.php');
JLoader::register('League\\Flysystem\\Filesystem', PRISM_PATH_LIBRARY . '/libs/Flysystem/Filesystem.php');
JLoader::register('League\\Flysystem\\FilesystemInterface', PRISM_PATH_LIBRARY . '/libs/Flysystem/FilesystemInterface.php');
JLoader::register('League\\Flysystem\\Handler', PRISM_PATH_LIBRARY . '/libs/Flysystem/Handler.php');
JLoader::register('League\\Flysystem\\MountManager', PRISM_PATH_LIBRARY . '/libs/Flysystem/MountManager.php');
JLoader::register('League\\Flysystem\\NotSupportedException', PRISM_PATH_LIBRARY . '/libs/Flysystem/NotSupportedException.php');
JLoader::register('League\\Flysystem\\PluginInterface', PRISM_PATH_LIBRARY . '/libs/Flysystem/PluginInterface.php');
JLoader::register('League\\Flysystem\\ReadInterface', PRISM_PATH_LIBRARY . '/libs/Flysystem/ReadInterface.php');
JLoader::register('League\\Flysystem\\RootViolationException', PRISM_PATH_LIBRARY . '/libs/Flysystem/RootViolationException.php');
JLoader::register('League\\Flysystem\\Util', PRISM_PATH_LIBRARY . '/libs/Flysystem/Util.php');

JLoader::register('League\\Flysystem\\Adapter\\AbstractAdapter', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/AbstractAdapter.php');
JLoader::register('League\\Flysystem\\Adapter\\AbstractFtpAdapter', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/AbstractFtpAdapter.php');
JLoader::register('League\\Flysystem\\Adapter\\Ftp', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/Ftp.php');
JLoader::register('League\\Flysystem\\Adapter\\Ftpd', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/Ftpd.php');
JLoader::register('League\\Flysystem\\Adapter\\Local', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/Local.php');
JLoader::register('League\\Flysystem\\Adapter\\NullAdapter', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/NullAdapter.php');
JLoader::register('League\\Flysystem\\Adapter\\SynologyFtp', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/SynologyFtp.php');
JLoader::register('League\\Flysystem\\Adapter\\Polyfill\\NotSupportingVisibilityTrait', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/Polyfill/NotSupportingVisibilityTrait.php');
JLoader::register('League\\Flysystem\\Adapter\\Polyfill\\StreamedCopyTrait', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/Polyfill/StreamedCopyTrait.php');
JLoader::register('League\\Flysystem\\Adapter\\Polyfill\\StreamedReadingTrait', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/Polyfill/StreamedReadingTrait.php');
JLoader::register('League\\Flysystem\\Adapter\\Polyfill\\StreamedTrait', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/Polyfill/StreamedTrait.php');
JLoader::register('League\\Flysystem\\Adapter\\Polyfill\\StreamedWritingTrait', PRISM_PATH_LIBRARY . '/libs/Flysystem/Adapter/Polyfill/StreamedWritingTrait.php');

JLoader::register('League\\Flysystem\\Plugin\\AbstractPlugin', PRISM_PATH_LIBRARY . '/libs/Flysystem/Plugin/AbstractPlugin.php');
JLoader::register('League\\Flysystem\\Plugin\\EmptyDir', PRISM_PATH_LIBRARY . '/libs/Flysystem/Plugin/EmptyDir.php');
JLoader::register('League\\Flysystem\\Plugin\\GetWithMetadata', PRISM_PATH_LIBRARY . '/libs/Flysystem/Plugin/GetWithMetadata.php');
JLoader::register('League\\Flysystem\\Plugin\\ListFiles', PRISM_PATH_LIBRARY . '/libs/Flysystem/Plugin/ListFiles.php');
JLoader::register('League\\Flysystem\\Plugin\\ListPaths', PRISM_PATH_LIBRARY . '/libs/Flysystem/Plugin/ListPaths.php');
JLoader::register('League\\Flysystem\\Plugin\\ListWith', PRISM_PATH_LIBRARY . '/libs/Flysystem/Plugin/ListWith.php');
JLoader::register('League\\Flysystem\\Plugin\\PluggableTrait', PRISM_PATH_LIBRARY . '/libs/Flysystem/Plugin/PluggableTrait.php');
JLoader::register('League\\Flysystem\\Plugin\\PluginNotFoundException', PRISM_PATH_LIBRARY . '/libs/Flysystem/Plugin/PluginNotFoundException.php');

JLoader::register('League\\Flysystem\\Util\\ContentListingFormatter', PRISM_PATH_LIBRARY . '/libs/Flysystem/Util/ContentListingFormatter.php');
JLoader::register('League\\Flysystem\\Util\\MimeType', PRISM_PATH_LIBRARY . '/libs/Flysystem/Util/MimeType.php');
