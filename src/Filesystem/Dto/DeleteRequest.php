<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Dto;

use Prism\Library\Prism\Contract\Filesystem\RemoveRequest;
use Prism\Library\Prism\Filesystem\Path;

/**
 * Request to local storage for removing a file.
 *
 * @package Prism\Library\Prism\Filesystem\Dto
 */
final class DeleteRequest implements RemoveRequest
{
    private string $filename;
    private Path $path;

    /**
     * @param string $filename
     * @param Path $path
     */
    public function __construct(string $filename, Path $path)
    {
        $this->filename = $filename;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return Path
     */
    public function getPath(): Path
    {
        return $this->path;
    }
}
