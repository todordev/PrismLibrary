<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem;

use Prism\Library\Prism\Domain\ExtractingToArray;

class File
{
    use ExtractingToArray;

    protected string $relative_path;
    protected string $filename;
    protected string $filepath;
    protected string $filetype;
    protected int $filesize;
    protected string $extension;
    protected string $mime;
    protected array $attributes;

    public function __construct(array $data = [])
    {
        $this->relative_path = array_key_exists('relative_path', $data) ? (string)$data['relative_path'] : '';
        $this->filename = array_key_exists('filename', $data) ? (string)$data['filename'] : '';
        $this->filepath = array_key_exists('filepath', $data) ? (string)$data['filepath'] : '';
        $this->filetype = array_key_exists('filetype', $data) ? (string)$data['filetype'] : '';
        $this->filesize = array_key_exists('filesize', $data) ? (int)$data['filesize'] : 0;
        $this->extension = array_key_exists('extension', $data) ? (string)$data['extension'] : '';
        $this->mime = array_key_exists('mime', $data) ? (string)$data['mime'] : '';
        $this->attributes = array_key_exists('attributes', $data) ? (array)$data['attributes'] : [];
    }

    /**
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }

    /**
     * @param string $filepath
     * @return File
     */
    public function setFilepath(string $filepath): File
    {
        $this->filepath = $filepath;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return File
     */
    public function setFilename(string $filename): File
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return int
     */
    public function getFilesize(): int
    {
        return $this->filesize;
    }

    /**
     * @param int $filesize
     * @return File
     */
    public function setFilesize(int $filesize): File
    {
        $this->filesize = $filesize;
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
    public function getFiletype(): string
    {
        return $this->filetype;
    }

    /**
     * @param string $filetype
     * @return File
     */
    public function setFiletype(string $filetype): File
    {
        $this->filetype = $filetype;
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
     * @return string
     */
    public function getRelativePath(): string
    {
        return $this->relative_path;
    }

    /**
     * @param string $relative_path
     * @return File
     */
    public function setRelativePath(string $relative_path): File
    {
        $this->relative_path = $relative_path;
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
}
