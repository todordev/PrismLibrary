<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem;


use Joomla\String\StringHelper;

class File
{
    protected $filePath;
    protected $fileName;
    protected $fileSize;
    protected $extension;
    protected $fileType;
    protected $mime;
    protected $attributes = [];

    public function __construct(array $fileData = [])
    {
        $this->filePath = array_key_exists('filepath', $fileData) ? (string)$fileData['filepath'] : '';
        $this->fileName = array_key_exists('filename', $fileData) ? (string)$fileData['filename'] : '';
        $this->fileSize = array_key_exists('filesize', $fileData) ? (int)$fileData['filesize'] : 0;
        $this->extension = array_key_exists('extension', $fileData) ? (string)$fileData['extension'] : '';
        $this->fileType = array_key_exists('filetype', $fileData) ? (string)$fileData['filetype'] : '';
        $this->mime = array_key_exists('mime', $fileData) ? (string)$fileData['mime'] : '';
        $this->attributes = array_key_exists('attributes', $fileData) ? (array)$fileData['attributes'] : [];
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     * @return File
     */
    public function setFilePath(string $filePath): File
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return File
     */
    public function setFileName(string $fileName): File
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    /**
     * @param int $fileSize
     * @return File
     */
    public function setFileSize(int $fileSize): File
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return File
     */
    public function setExtension(string $extension): File
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileType(): string
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     * @return File
     */
    public function setFileType(string $fileType): File
    {
        $this->fileType = $fileType;
        return $this;
    }

    /**
     * @return string
     */
    public function getMime(): string
    {
        return $this->mime;
    }

    /**
     * @param string $mime
     * @return File
     */
    public function setMime(string $mime): File
    {
        $this->mime = $mime;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return File
     */
    public function setAttributes(array $attributes): File
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Check if the file extension belongs to image.
     *
     * @return bool
     */
    public function hasImageExtension(): bool
    {
        $extensions     = ['jpg', 'jpeg', 'webp', 'gif', 'png'];
        return ($this->extension && in_array($this->extension, $extensions, true));
    }

    /**
     * Check the file type if it is image.
     *
     * <code>
     * $file = new Prism\Library\Prism\Filesystem\File();
     *
     * if ($file->isImage()) {
     * // ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return strcmp($this->fileType, 'image') === 0;
    }

    /**
     * Check the file type if it is video.
     *
     * <code>
     * $file = new Prism\Library\Prism\Filesystem\File();
     *
     * if ($file->isVideo()) {
     * // ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isVideo(): bool
    {
        return strcmp($this->fileType, 'video') === 0;
    }
}
