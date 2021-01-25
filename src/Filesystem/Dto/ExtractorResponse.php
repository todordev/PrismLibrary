<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Dto;

/**
 * Response from a service that extracts data from a file.
 *
 * @package Prism\Library\Prism\Filesystem\Dto
 */
final class ExtractorResponse
{
    private string $fileName;
    private int $fileSize;
    private string $mimeType;
    private string $extension;
    private string $fileType;

    public function __construct(
        string $fileName,
        int $fileSize,
        string $mimeType,
        string $extension,
        string $fileType
    ) {
        $this->fileName = $fileName;
        $this->fileSize = $fileSize;
        $this->mimeType = $mimeType;
        $this->extension = $extension;
        $this->fileType = $fileType;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getFileType(): string
    {
        return $this->fileType;
    }
}
