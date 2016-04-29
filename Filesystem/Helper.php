<?php
/**
 * @package      Prism
 * @subpackage   Filesystem
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Filesystem;

use Joomla\Registry\Registry;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Aws\S3\S3Client;

// no direct access
defined('_JEXEC') or die;

jimport('joomla.filesystem.path');

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
     * @return Filesystem
     */
    public function getFilesystem()
    {
        switch($this->params->get('filesystem', 'local')) {
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
                $storageAdapter      = new Local(JPATH_BASE);
                $storageFilesystem   = new Filesystem($storageAdapter);
                break;
        }

        return $storageFilesystem;
    }

    /**
     * Generate a path to the temporary media folder.
     *
     * @param string $root   A base path to the folder. It can be JPATH_BASE, JPATH_ROOT, JPATH_SITE,...
     *
     * @return string
     */
    public function getTemporaryMediaFolder($root = '')
    {
        return \JPath::clean($root .'/'. $this->params->get('local_media_folder', 'images') . '/temporary', '/');
    }

    /**
     * Generate a URI path to the temporary media folder.
     *
     * @return string
     */
    public function getTemporaryMediaFolderUri()
    {
        return $this->params->get('local_media_folder', 'images') . '/temporary';
    }

    /**
     * Generate a path to the folder where the media files wil be stored.
     *
     * @param int    $userId User Id.
     *
     * @return string
     */
    public function getMediaFolder($userId = 0)
    {
        switch($this->params->get('filesystem', 'local')) {
            case 'amazon_s3':
                $folder = $this->params->get('remote_media_folder', 'media');
                break;

            default:
                $folder = $this->params->get('local_media_folder', 'images');
                break;
        }

        if ((int)$userId > 0) {
            $folder .= '/user' . (int)$userId;
        }

        return \JPath::clean($folder, '/');
    }

    /**
     * Generate a URI path to the folder, where the media files are stored.
     *
     * @param int $userId User Id.
     *
     * @return string
     */
    public function getMediaFolderUri($userId = 0)
    {
        switch($this->params->get('filesystem', 'local')) {
            case 'amazon_s3':
                $uriImages = $this->params->get('remote_domain') . $this->params->get('remote_media_folder', 'media');
                break;

            default:
                $uriImages = \JUri::root() . $this->params->get('local_media_folder', 'images');
                break;
        }

        if ((int)$userId > 0) {
            $uriImages .= '/user' . (int)$userId;
        }

        return $uriImages;
    }

    /**
     * Check if it is local filesystem.
     *
     * @return bool
     */
    public function isLocal()
    {
        return ($this->params->get('filesystem', 'local') === 'local');
    }
}
