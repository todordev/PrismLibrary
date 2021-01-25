<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Dto;

use Prism\Library\Prism\Filesystem\Path;
use Prism\Library\Prism\Filesystem\Storage\FileData;
use Prism\Library\Prism\Contract\Filesystem\StoreRequest;

/**
 * Request to the service that will upload a file.
 *
 * @package Prism\Library\Prism\Filesystem\Dto
 */
final class UploadRequest implements StoreRequest
{
    private FileData $fileData;
    private int $filenameLength;
    private string $filename;
    private Path $destinationPath;

    public function __construct(
        FileData $fileData,
        Path $destinationPath,
        int $filenameLength = 16,
        string $filename = '',
    ) {
        $this->fileData = $fileData;
        $this->filenameLength = $filenameLength;
        $this->filename = $filename;
        $this->destinationPath = $destinationPath;
    }

    public function getFileData(): FileData
    {
        return $this->fileData;
    }

    public function getDestinationPath(): Path
    {
        return $this->destinationPath;
    }

    public function getFilenameLength(): int
    {
        return $this->filenameLength;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
