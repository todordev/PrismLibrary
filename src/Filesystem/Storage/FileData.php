<?php
/**
 * @package      Prism
 * @subpackage   Filesystem\Adapters
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Storage;

/**
 * Information about a file that should be provided to the storage repository.
 * @package      Prism\Library\Prism\Filesystem\Storage
 */
final class FileData
{
    private string $filePath;
    private string $name;
    private int $serverError;

    /**
     * Initialize the object.
     * <code>
     * $storageFolder = new Path('/var/www/mysite/images', '/images');
     * $fileData = new FileData($fileData['tmp_name'], $fileData['name'], $fileData['error']);
     * </code>
     *
     * @param string $filePath
     * @param string $name
     * @param int $serverError
     */
    public function __construct(string $filePath, string $name = '', int $serverError = 0)
    {
        $this->filePath = $filePath;
        $this->name = $name;
        $this->serverError = $serverError;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getServerError(): int
    {
        return $this->serverError;
    }
}
