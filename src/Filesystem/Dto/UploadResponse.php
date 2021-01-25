<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Dto;

use Prism\Library\Prism\Filesystem\Path;
use Prism\Library\Prism\Contract\Filesystem\StoreResponse;

/**
 * Response after file uploading.
 *
 * @package Prism\Library\Prism\Filesystem\Dto
 */
final class UploadResponse implements StoreResponse
{
    private string $filename;
    private Path $path;

    public function __construct(
        string $filename,
        Path $path,
    ) {
        $this->filename = $filename;
        $this->path = $path;
    }

    /**
     * @return Path
     */
    public function getPath(): Path
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }
}
