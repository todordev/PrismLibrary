<?php
/**
 * @package      Prism\Library\Prism\Filesystem
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem;

class File
{
    protected string $name;
    protected FilePath $path;
    protected string $type;
    protected int $size;
    protected string $extension;
    protected string $mime;
    protected array $attributes;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return FilePath
     */
    public function path(): FilePath
    {
        return $this->path;
    }

    /**
     * @param FilePath $path
     * @return File
     */
    public function setFilepath(FilePath $path): File
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return File
     */
    public function setName(string $name): File
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return File
     */
    public function setFilesize(int $size): File
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string
     */
    public function extension(): string
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
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return File
     */
    public function setType(string $type): File
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function mime(): string
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
    public function attributes(): array
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
