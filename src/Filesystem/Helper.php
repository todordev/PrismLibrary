<?php
/**
 * @package      Prism
 * @subpackage   Filesystem
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Filesystem;

use Joomla\Registry\Registry;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Aws\S3\S3Client;

/**
 * Filesystem helper.
 *
 * @package         Prism
 * @subpackage      Filesystem
 */
final class Helper
{
    /**
     * @var Registry
     */
    private $params;

    public function __construct(Registry $params)
    {
        $this->params = $params;
    }

    /**
     * Prepare storage filesystem.
     *
     * <code>
     * $params = JComponentHelper::getParams('com_magicgallery');
     *
     * $filesystemHelper  = new Prism\Library\Filesystem\Helper($params);
     * $storageFilesystem = $filesystemHelper->getFilesystem();
     * </code>
     *
     * @throws \InvalidArgumentException
     * @return Filesystem
     */
    public function getFilesystem()
    {
        switch ($this->params->get('filesystem', 'local')) {
            case 'amazon_s3':
                $client = new S3Client([
                    'credentials' => [
                        'key'    => $this->params->get('amazon_key'),
                        'secret' => $this->params->get('amazon_secret'),
                    ],
                    'region' => $this->params->get('amazon_region'),
                    'version' => 'latest'
                ]);

                $storageAdapter      = new AwsS3Adapter($client, $this->params->get('amazon_bucket'));
                $storageFilesystem   = new Filesystem($storageAdapter);
                break;

            default:
                $storageAdapter      = new Local(JPATH_ROOT);
                $storageFilesystem   = new Filesystem($storageAdapter);
                break;
        }

        return $storageFilesystem;
    }

    /**
     * Generate a path to the temporary media folder.
     *
     * <code>
     * $params = JComponentHelper::getParams('com_magicgallery');
     *
     * $filesystemHelper  = new Prism\Library\Filesystem\Helper($params);
     * $temporaryFolder   = $filesystemHelper->getTemporaryMediaFolder();
     * </code>
     *
     * @param string $root   A base path to the folder. It can be JPATH_BASE, JPATH_ROOT, JPATH_SITE,...
     *
     * @throws \UnexpectedValueException
     *
     * @return string
     */
    public function getTemporaryMediaFolder($root = '')
    {
        return \JPath::clean($root .'/'. $this->params->get('local_media_folder', 'media') . '/temporary', '/');
    }

    /**
     * Generate a URI path to the temporary media folder.
     *
     * <code>
     * $params = JComponentHelper::getParams('com_magicgallery');
     *
     * $filesystemHelper   = new Prism\Library\Filesystem\Helper($params);
     * $temporaryFolderUri = $filesystemHelper->getTemporaryMediaFolderUri();
     * </code>
     *
     * @param string $root A base path to the folder. It could be \JUri::root(), https://domain.com/path,...
     *
     * @return string
     */
    public function getTemporaryMediaFolderUri($root = '')
    {
        return $root . $this->params->get('local_media_folder', 'media') . '/temporary';
    }

    /**
     * Generate a path to the folder where the media files wil be stored.
     *
     * <code>
     * $params = JComponentHelper::getParams('com_magicgallery');
     *
     * $filesystemHelper   = new Prism\Library\Filesystem\Helper($params);
     * $mediaFolder = $filesystemHelper->getMediaFolder();
     * </code>
     *
     * @param int    $id Id.
     * @param string $folderName
     *
     * @throws \UnexpectedValueException
     * @return string
     */
    public function getMediaFolder($id = 0, $folderName = 'user')
    {
        switch ($this->params->get('filesystem', 'local')) {
            case 'amazon_s3':
                $folder = $this->params->get('remote_media_folder', 'media');
                break;

            default:
                $folder = $this->params->get('local_media_folder', 'media');
                break;
        }

        if ((int)$id > 0) {
            $folderName = $folderName ?: 'user';
            $folder .= '/'.$folderName . (int)$id;
        }

        return $folder ? \JPath::clean($folder, '/') : '';
    }

    /**
     * Generate a URI path to the folder, where the media files are stored.
     *
     * <code>
     * $params = JComponentHelper::getParams('com_magicgallery');
     *
     * $filesystemHelper  = new Prism\Library\Filesystem\Helper($params);
     * $mediaFolderUri    = $filesystemHelper->getMediaFolderUri();
     * </code>
     *
     * @param int $id
     * @param string $folderName
     * @param string $uri
     *
     * @return string URL to the media folder
     */
    public function getMediaFolderUri($id = 0, $folderName = 'user', $uri = '')
    {
        switch ($this->params->get('filesystem', 'local')) {
            case 'amazon_s3':
                $uri = ($uri !== '') ? $this->cleanUri($uri) : $this->cleanUri($this->params->get('remote_media_folder', 'media'));
                $mediaUrl = $this->params->get('remote_domain') . '/'. $uri;
                break;

            default:
                $uri = ($uri !== '') ? $this->cleanUri($uri) : $this->cleanUri($this->params->get('local_media_folder', 'media'));
                $mediaUrl = \JUri::root() . $uri;
                break;
        }

        if ((int)$id > 0) {
            $folderName = $folderName ?: 'user';
            $mediaUrl .= '/'.$folderName . (int)$id;
        }

        return $mediaUrl;
    }

    /**
     * Remove first slash from URI string.
     *
     * @param $uri
     *
     * @return string
     */
    protected function cleanUri($uri)
    {
        return (string)preg_replace('/^\//', '', $uri);
    }

    /**
     * Check if it is local filesystem.
     *
     * <code>
     * $params = JComponentHelper::getParams('com_magicgallery');
     *
     * $filesystemHelper   = new Prism\Library\Filesystem\Helper($params);
     * if ($filesystemHelper->isLocal()) {
     * //....
     * }
     * </code>
     *
     * @return bool
     */
    public function isLocal()
    {
        return ($this->params->get('filesystem', 'local') === 'local');
    }
}
